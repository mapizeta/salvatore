<?php

namespace App\Controllers;

use App\Models\SaleModel;
use App\Models\CustomerModel;
use CodeIgniter\Controller;

class Sales extends Controller
{
    protected $saleModel;
    protected $customerModel;

    public function __construct()
    {
        $this->saleModel = new SaleModel();
        $this->customerModel = new CustomerModel();
    }

    public function index()
    {
        return view('sales/index');
    }

    // API para obtener ventas
    public function getSales()
    {
        try {
            $sales = $this->saleModel
                ->select('sales.*, customers.name as customer_name')
                ->join('customers', 'customers.id = sales.customer_id', 'left')
                ->orderBy('sales.created_at', 'DESC')
                ->findAll();
            
            // Agregar conteo de productos por venta
            foreach ($sales as &$sale) {
                $sale['product_count'] = $this->saleModel->getProductCount($sale['id']);
            }
            
            return $this->response->setJSON($sales);
        } catch (\Exception $e) {
            log_message('error', 'Error obteniendo ventas: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Error interno del servidor'])->setStatusCode(500);
        }
    }

    // API para obtener una venta específica
    public function getSale($id = null)
    {
        try {
            if (!$id) {
                return $this->response->setJSON(['error' => 'ID requerido'])->setStatusCode(400);
            }

            $sale = $this->saleModel
                ->select('sales.*, customers.name as customer_name, customers.email as customer_email')
                ->join('customers', 'customers.id = sales.customer_id', 'left')
                ->find($id);

            if (!$sale) {
                return $this->response->setJSON(['error' => 'Venta no encontrada'])->setStatusCode(404);
            }

            // Obtener items de la venta
            $sale['items'] = $this->saleModel->getSaleItems($id);
            
            return $this->response->setJSON($sale);
        } catch (\Exception $e) {
            log_message('error', 'Error obteniendo venta: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Error interno del servidor'])->setStatusCode(500);
        }
    }

    // API para crear venta
    public function create()
    {
        try {
            $data = $this->request->getJSON(true);
            
            // Validar datos básicos
            if (empty($data['customer_id']) || empty($data['payment_method'])) {
                return $this->response->setJSON(['error' => 'Datos requeridos faltantes'])->setStatusCode(400);
            }

            // Agregar usuario actual
            $data['user_id'] = session()->get('user_id');
            
            // Calcular total si no se proporciona
            if (empty($data['total'])) {
                $data['total'] = 0; // Se calculará con los items
            }

            $saleId = $this->saleModel->insert($data);
            
            if ($saleId) {
                $sale = $this->saleModel->find($saleId);
                return $this->response->setJSON($sale)->setStatusCode(201);
            } else {
                return $this->response->setJSON(['error' => 'Error creando venta'])->setStatusCode(500);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error creando venta: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Error interno del servidor'])->setStatusCode(500);
        }
    }

    // API para actualizar venta
    public function update($id = null)
    {
        try {
            if (!$id) {
                return $this->response->setJSON(['error' => 'ID requerido'])->setStatusCode(400);
            }

            $data = $this->request->getJSON(true);
            
            // Validar que la venta existe
            $existingSale = $this->saleModel->find($id);
            if (!$existingSale) {
                return $this->response->setJSON(['error' => 'Venta no encontrada'])->setStatusCode(404);
            }

            $success = $this->saleModel->update($id, $data);
            
            if ($success) {
                $sale = $this->saleModel->find($id);
                return $this->response->setJSON($sale);
            } else {
                return $this->response->setJSON(['error' => 'Error actualizando venta'])->setStatusCode(500);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error actualizando venta: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Error interno del servidor'])->setStatusCode(500);
        }
    }

    // API para eliminar venta
    public function delete($id = null)
    {
        try {
            if (!$id) {
                return $this->response->setJSON(['error' => 'ID requerido'])->setStatusCode(400);
            }

            // Validar que la venta existe
            $existingSale = $this->saleModel->find($id);
            if (!$existingSale) {
                return $this->response->setJSON(['error' => 'Venta no encontrada'])->setStatusCode(404);
            }

            $success = $this->saleModel->delete($id);
            
            if ($success) {
                return $this->response->setJSON(['message' => 'Venta eliminada']);
            } else {
                return $this->response->setJSON(['error' => 'Error eliminando venta'])->setStatusCode(500);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error eliminando venta: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Error interno del servidor'])->setStatusCode(500);
        }
    }
} 