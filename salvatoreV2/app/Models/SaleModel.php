<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleModel extends Model
{
    protected $table = 'sales';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'customer_id',
        'user_id',
        'total',
        'tax',
        'discount',
        'payment_method',
        'status',
        'notes'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'customer_id' => 'permit_empty|integer',
        'user_id' => 'required|integer',
        'total' => 'required|numeric|greater_than[0]',
        'tax' => 'permit_empty|numeric|greater_than_equal_to[0]',
        'discount' => 'permit_empty|numeric|greater_than_equal_to[0]',
        'payment_method' => 'required|in_list[cash,card,transfer]',
        'status' => 'required|in_list[pending,completed,cancelled]'
    ];

    protected $validationMessages = [
        'user_id' => [
            'required' => 'El usuario es requerido',
            'integer' => 'El usuario debe ser un número entero'
        ],
        'total' => [
            'required' => 'El total es requerido',
            'numeric' => 'El total debe ser un número',
            'greater_than' => 'El total debe ser mayor a 0'
        ],
        'payment_method' => [
            'required' => 'El método de pago es requerido',
            'in_list' => 'El método de pago debe ser cash, card o transfer'
        ],
        'status' => [
            'required' => 'El estado es requerido',
            'in_list' => 'El estado debe ser pending, completed o cancelled'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Métodos personalizados
    public function getProductsSoldToday()
    {
        $db = \Config\Database::connect();
        $sql = "
            SELECT SUM(si.quantity) as total_quantity
            FROM sale_items si
            JOIN sales s ON si.sale_id = s.id
            WHERE DATE(s.created_at) = CURDATE()
        ";
        
        $result = $db->query($sql)->getRow();
        return $result ? $result->total_quantity : 0;
    }

    public function getProductCount($saleId)
    {
        $db = \Config\Database::connect();
        $sql = "
            SELECT COUNT(*) as product_count
            FROM sale_items
            WHERE sale_id = ?
        ";
        
        $result = $db->query($sql, [$saleId])->getRow();
        return $result ? $result->product_count : 0;
    }

    public function getSalesWithDetails($limit = null, $offset = 0)
    {
        $builder = $this->db->table('sales s')
            ->select('s.*, c.name as customer_name, u.name as user_name')
            ->join('customers c', 'c.id = s.customer_id', 'left')
            ->join('users u', 'u.id = s.user_id', 'left')
            ->orderBy('s.created_at', 'DESC');

        if ($limit) {
            $builder->limit($limit, $offset);
        }

        return $builder->get()->getResultArray();
    }

    public function getSalesByDateRange($startDate, $endDate)
    {
        return $this->where('DATE(created_at) >=', $startDate)
                    ->where('DATE(created_at) <=', $endDate)
                    ->where('status', 'completed')
                    ->findAll();
    }

    public function getDailySales($date = null)
    {
        if (!$date) {
            $date = date('Y-m-d');
        }

        return $this->where('DATE(created_at)', $date)
                    ->where('status', 'completed')
                    ->selectSum('total')
                    ->get()
                    ->getRow()
                    ->total ?? 0;
    }

    public function getMonthlySales($year = null, $month = null)
    {
        if (!$year) $year = date('Y');
        if (!$month) $month = date('m');

        return $this->where('YEAR(created_at)', $year)
                    ->where('MONTH(created_at)', $month)
                    ->where('status', 'completed')
                    ->selectSum('total')
                    ->get()
                    ->getRow()
                    ->total ?? 0;
    }

    public function getTopSellingProducts($limit = 10, $dateRange = null)
    {
        $db = \Config\Database::connect();
        
        $whereClause = "WHERE s.status = 'completed'";
        if ($dateRange) {
            $whereClause .= " AND s.created_at >= '{$dateRange['start']}' AND s.created_at <= '{$dateRange['end']}'";
        }

        $sql = "
            SELECT 
                p.id,
                p.name,
                p.category,
                SUM(si.quantity) as total_quantity,
                SUM(si.quantity * si.price) as total_revenue
            FROM sale_items si
            JOIN sales s ON si.sale_id = s.id
            JOIN products p ON si.product_id = p.id
            {$whereClause}
            GROUP BY p.id, p.name, p.category
            ORDER BY total_quantity DESC
            LIMIT {$limit}
        ";

        return $db->query($sql)->getResultArray();
    }

    public function createSaleWithItems($saleData, $items)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Crear la venta
            $saleId = $this->insert($saleData);

            // Insertar items de la venta
            $saleItemModel = new SaleItemModel();
            foreach ($items as $item) {
                $item['sale_id'] = $saleId;
                $saleItemModel->insert($item);

                // Actualizar stock del producto
                $productModel = new ProductModel();
                $product = $productModel->find($item['product_id']);
                if ($product) {
                    $newStock = $product['stock'] - $item['quantity'];
                    $productModel->update($item['product_id'], ['stock' => $newStock]);
                }
            }

            $db->transComplete();
            return $db->transStatus() ? $saleId : false;

        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Error creando venta: ' . $e->getMessage());
            return false;
        }
    }
} 