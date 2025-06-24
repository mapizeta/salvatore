<?php

namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\Controller;

class Products extends Controller
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        return view('products/index');
    }

    // API para obtener productos
    public function getProducts()
    {
        try {
            $products = $this->productModel->where('active', 1)->findAll();
            
            return $this->response->setJSON($products);
        } catch (\Exception $e) {
            log_message('error', 'Error obteniendo productos: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Error interno del servidor'])->setStatusCode(500);
        }
    }

    // API para crear producto
    public function create()
    {
        try {
            $data = $this->request->getJSON(true);
            
            // Validar datos
            if (!$this->productModel->validate($data)) {
                return $this->response->setJSON([
                    'error' => 'Datos inválidos',
                    'validation' => $this->productModel->errors()
                ])->setStatusCode(400);
            }

            $productId = $this->productModel->insert($data);
            
            if ($productId) {
                $product = $this->productModel->find($productId);
                return $this->response->setJSON($product)->setStatusCode(201);
            } else {
                return $this->response->setJSON(['error' => 'Error creando producto'])->setStatusCode(500);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error creando producto: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Error interno del servidor'])->setStatusCode(500);
        }
    }

    // API para actualizar producto
    public function update($id = null)
    {
        try {
            if (!$id) {
                return $this->response->setJSON(['error' => 'ID requerido'])->setStatusCode(400);
            }

            $data = $this->request->getJSON(true);
            
            // Validar datos
            if (!$this->productModel->validate($data)) {
                return $this->response->setJSON([
                    'error' => 'Datos inválidos',
                    'validation' => $this->productModel->errors()
                ])->setStatusCode(400);
            }

            $success = $this->productModel->update($id, $data);
            
            if ($success) {
                $product = $this->productModel->find($id);
                return $this->response->setJSON($product);
            } else {
                return $this->response->setJSON(['error' => 'Error actualizando producto'])->setStatusCode(500);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error actualizando producto: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Error interno del servidor'])->setStatusCode(500);
        }
    }

    // API para eliminar producto
    public function delete($id = null)
    {
        try {
            if (!$id) {
                return $this->response->setJSON(['error' => 'ID requerido'])->setStatusCode(400);
            }

            $success = $this->productModel->delete($id);
            
            if ($success) {
                return $this->response->setJSON(['message' => 'Producto eliminado']);
            } else {
                return $this->response->setJSON(['error' => 'Error eliminando producto'])->setStatusCode(500);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error eliminando producto: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Error interno del servidor'])->setStatusCode(500);
        }
    }
} 