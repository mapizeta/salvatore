<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use CodeIgniter\Controller;

class Customers extends Controller
{
    protected $customerModel;

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
    }

    public function index()
    {
        return view('customers/index');
    }

    // API para obtener clientes
    public function getCustomers()
    {
        try {
            $customers = $this->customerModel->where('active', 1)->findAll();
            
            return $this->response->setJSON($customers);
        } catch (\Exception $e) {
            log_message('error', 'Error obteniendo clientes: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Error interno del servidor'])->setStatusCode(500);
        }
    }

    // API para crear cliente
    public function create()
    {
        try {
            $data = $this->request->getJSON(true);
            
            // Validar datos
            if (!$this->customerModel->validate($data)) {
                return $this->response->setJSON([
                    'error' => 'Datos inválidos',
                    'validation' => $this->customerModel->errors()
                ])->setStatusCode(400);
            }

            $customerId = $this->customerModel->insert($data);
            
            if ($customerId) {
                $customer = $this->customerModel->find($customerId);
                return $this->response->setJSON($customer)->setStatusCode(201);
            } else {
                return $this->response->setJSON(['error' => 'Error creando cliente'])->setStatusCode(500);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error creando cliente: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Error interno del servidor'])->setStatusCode(500);
        }
    }

    // API para actualizar cliente
    public function update($id = null)
    {
        try {
            if (!$id) {
                return $this->response->setJSON(['error' => 'ID requerido'])->setStatusCode(400);
            }

            $data = $this->request->getJSON(true);
            
            // Validar datos
            if (!$this->customerModel->validate($data)) {
                return $this->response->setJSON([
                    'error' => 'Datos inválidos',
                    'validation' => $this->customerModel->errors()
                ])->setStatusCode(400);
            }

            $success = $this->customerModel->update($id, $data);
            
            if ($success) {
                $customer = $this->customerModel->find($id);
                return $this->response->setJSON($customer);
            } else {
                return $this->response->setJSON(['error' => 'Error actualizando cliente'])->setStatusCode(500);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error actualizando cliente: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Error interno del servidor'])->setStatusCode(500);
        }
    }

    // API para eliminar cliente
    public function delete($id = null)
    {
        try {
            if (!$id) {
                return $this->response->setJSON(['error' => 'ID requerido'])->setStatusCode(400);
            }

            $success = $this->customerModel->delete($id);
            
            if ($success) {
                return $this->response->setJSON(['message' => 'Cliente eliminado']);
            } else {
                return $this->response->setJSON(['error' => 'Error eliminando cliente'])->setStatusCode(500);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error eliminando cliente: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Error interno del servidor'])->setStatusCode(500);
        }
    }
} 