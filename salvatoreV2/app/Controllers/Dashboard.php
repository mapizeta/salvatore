<?php

namespace App\Controllers;

use App\Models\SaleModel;
use App\Models\ProductModel;
use App\Models\CustomerModel;
use CodeIgniter\Controller;

class Dashboard extends Controller
{
    protected $saleModel;
    protected $productModel;
    protected $customerModel;

    public function __construct()
    {
        $this->saleModel = new SaleModel();
        $this->productModel = new ProductModel();
        $this->customerModel = new CustomerModel();
    }

    public function index()
    {
        // Log para debugging
        log_message('info', 'Dashboard::index - Llegando al dashboard');
        log_message('info', 'Dashboard::index - Session logged_in: ' . (session()->get('logged_in') ? 'true' : 'false'));
        log_message('info', 'Dashboard::index - Session data: ' . json_encode(session()->get()));
        
        // El filtro de autenticación ya verifica la sesión
        return view('dashboard/index');
    }

    // API para obtener estadísticas del dashboard
    public function getStats()
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON(['error' => 'No autenticado'])->setStatusCode(401);
        }

        try {
            // Ventas del día
            $today = date('Y-m-d');
            $dailySales = $this->saleModel->where('DATE(created_at)', $today)->selectSum('total')->get()->getRow()->total ?? 0;

            // Productos vendidos hoy
            $productsSold = $this->saleModel->getProductsSoldToday();

            // Clientes nuevos hoy
            $newCustomers = $this->customerModel->where('DATE(created_at)', $today)->countAllResults();

            // Transacciones hoy
            $transactions = $this->saleModel->where('DATE(created_at)', $today)->countAllResults();

            // Ventas de la semana
            $weeklySales = $this->getWeeklySales();

            // Productos más vendidos
            $topProducts = $this->getTopProducts();

            // Actividad reciente
            $recentActivity = $this->getRecentActivity();

            return $this->response->setJSON([
                'dailySales' => (float) $dailySales,
                'productsSold' => (int) $productsSold,
                'newCustomers' => (int) $newCustomers,
                'transactions' => (int) $transactions,
                'weeklySales' => $weeklySales,
                'topProducts' => $topProducts,
                'recentActivity' => $recentActivity
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error obteniendo estadísticas del dashboard: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Error interno del servidor'])->setStatusCode(500);
        }
    }

    private function getWeeklySales()
    {
        $db = \Config\Database::connect();
        $sql = "
            SELECT 
                DATE(created_at) as day,
                SUM(total) as sales
            FROM sales 
            WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
            GROUP BY DATE(created_at)
            ORDER BY day
        ";
        
        $result = $db->query($sql)->getResultArray();
        
        // Llenar días faltantes con 0
        $weeklySales = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-{$i} days"));
            $found = false;
            
            foreach ($result as $row) {
                if ($row['day'] == $date) {
                    $weeklySales[] = [
                        'day' => date('D', strtotime($date)),
                        'sales' => (float) $row['sales']
                    ];
                    $found = true;
                    break;
                }
            }
            
            if (!$found) {
                $weeklySales[] = [
                    'day' => date('D', strtotime($date)),
                    'sales' => 0
                ];
            }
        }
        
        return $weeklySales;
    }

    private function getTopProducts()
    {
        $db = \Config\Database::connect();
        $sql = "
            SELECT 
                p.name,
                p.category,
                SUM(si.quantity) as quantity
            FROM sale_items si
            JOIN products p ON si.product_id = p.id
            JOIN sales s ON si.sale_id = s.id
            WHERE s.created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
            GROUP BY p.id, p.name, p.category
            ORDER BY quantity DESC
            LIMIT 5
        ";
        
        $result = $db->query($sql)->getResultArray();
        
        return array_map(function($row) {
            return [
                'name' => $row['name'],
                'category' => $row['category'],
                'quantity' => (int) $row['quantity']
            ];
        }, $result);
    }

    private function getRecentActivity()
    {
        $recentSales = $this->saleModel
            ->select('sales.id, sales.total, sales.created_at, customers.name as customer_name')
            ->join('customers', 'customers.id = sales.customer_id', 'left')
            ->orderBy('sales.created_at', 'DESC')
            ->limit(10)
            ->findAll();

        $activity = [];
        foreach ($recentSales as $sale) {
            // Contar productos en la venta
            $productCount = $this->saleModel->getProductCount($sale['id']);
            
            $activity[] = [
                'id' => $sale['id'],
                'customer' => $sale['customer_name'] ?? 'Cliente General',
                'products' => $productCount,
                'total' => (float) $sale['total'],
                'status' => 'completed',
                'date' => $sale['created_at']
            ];
        }
        
        return $activity;
    }
} 