<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleItemModel extends Model
{
    protected $table = 'sale_items';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'sale_id',
        'product_id',
        'quantity',
        'price',
        'discount',
        'total'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'sale_id' => 'required|integer',
        'product_id' => 'required|integer',
        'quantity' => 'required|integer|greater_than[0]',
        'price' => 'required|numeric|greater_than[0]',
        'discount' => 'permit_empty|numeric|greater_than_equal_to[0]',
        'total' => 'required|numeric|greater_than_equal_to[0]'
    ];

    protected $validationMessages = [
        'sale_id' => [
            'required' => 'El ID de venta es requerido',
            'integer' => 'El ID de venta debe ser un número entero'
        ],
        'product_id' => [
            'required' => 'El ID de producto es requerido',
            'integer' => 'El ID de producto debe ser un número entero'
        ],
        'quantity' => [
            'required' => 'La cantidad es requerida',
            'integer' => 'La cantidad debe ser un número entero',
            'greater_than' => 'La cantidad debe ser mayor a 0'
        ],
        'price' => [
            'required' => 'El precio es requerido',
            'numeric' => 'El precio debe ser un número',
            'greater_than' => 'El precio debe ser mayor a 0'
        ],
        'discount' => [
            'numeric' => 'El descuento debe ser un número',
            'greater_than_equal_to' => 'El descuento debe ser mayor o igual a 0'
        ],
        'total' => [
            'required' => 'El total es requerido',
            'numeric' => 'El total debe ser un número',
            'greater_than_equal_to' => 'El total debe ser mayor o igual a 0'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $beforeInsert = ['calculateTotal'];
    protected $beforeUpdate = ['calculateTotal'];

    protected function calculateTotal(array $data)
    {
        if (isset($data['data']['quantity']) && isset($data['data']['price'])) {
            $quantity = $data['data']['quantity'];
            $price = $data['data']['price'];
            $discount = $data['data']['discount'] ?? 0;

            $subtotal = $quantity * $price;
            $total = $subtotal - $discount;

            $data['data']['total'] = $total;
        }

        return $data;
    }

    // Métodos personalizados
    public function getItemsBySale($saleId)
    {
        return $this->select('sale_items.*, products.name as product_name, products.sku')
                    ->join('products', 'products.id = sale_items.product_id')
                    ->where('sale_id', $saleId)
                    ->findAll();
    }

    public function getItemsWithProductDetails($saleId)
    {
        return $this->select('
                        sale_items.*,
                        products.name as product_name,
                        products.sku,
                        products.barcode,
                        products.category
                    ')
                    ->join('products', 'products.id = sale_items.product_id')
                    ->where('sale_id', $saleId)
                    ->findAll();
    }

    public function getSaleTotal($saleId)
    {
        $result = $this->where('sale_id', $saleId)
                       ->selectSum('total')
                       ->get()
                       ->getRow();
        
        return $result ? $result->total : 0;
    }

    public function getTopSellingItems($limit = 10, $dateRange = null)
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
                p.sku,
                p.category,
                SUM(si.quantity) as total_quantity,
                SUM(si.total) as total_revenue,
                AVG(si.price) as avg_price
            FROM sale_items si
            JOIN sales s ON si.sale_id = s.id
            JOIN products p ON si.product_id = p.id
            {$whereClause}
            GROUP BY p.id, p.name, p.sku, p.category
            ORDER BY total_quantity DESC
            LIMIT {$limit}
        ";

        return $db->query($sql)->getResultArray();
    }

    public function getDailySalesByProduct($date = null)
    {
        if (!$date) {
            $date = date('Y-m-d');
        }

        $db = \Config\Database::connect();
        $sql = "
            SELECT 
                p.name,
                p.category,
                SUM(si.quantity) as quantity_sold,
                SUM(si.total) as revenue
            FROM sale_items si
            JOIN sales s ON si.sale_id = s.id
            JOIN products p ON si.product_id = p.id
            WHERE DATE(s.created_at) = ?
            AND s.status = 'completed'
            GROUP BY p.id, p.name, p.category
            ORDER BY quantity_sold DESC
        ";

        return $db->query($sql, [$date])->getResultArray();
    }

    public function getProductSalesHistory($productId, $limit = 50)
    {
        return $this->select('
                        sale_items.*,
                        sales.created_at as sale_date,
                        sales.status as sale_status
                    ')
                    ->join('sales', 'sales.id = sale_items.sale_id')
                    ->where('product_id', $productId)
                    ->where('sales.status', 'completed')
                    ->orderBy('sales.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function getRefundedItems($saleId)
    {
        return $this->where('sale_id', $saleId)
                    ->where('quantity <', 0)
                    ->findAll();
    }

    public function createRefundItem($saleId, $productId, $quantity, $reason = '')
    {
        // Obtener el item original
        $originalItem = $this->where('sale_id', $saleId)
                            ->where('product_id', $productId)
                            ->first();

        if (!$originalItem) {
            return false;
        }

        // Crear item de reembolso (cantidad negativa)
        $refundData = [
            'sale_id' => $saleId,
            'product_id' => $productId,
            'quantity' => -$quantity, // Cantidad negativa para reembolso
            'price' => $originalItem['price'],
            'discount' => 0,
            'total' => -($quantity * $originalItem['price'])
        ];

        return $this->insert($refundData);
    }
} 