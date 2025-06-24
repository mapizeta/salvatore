<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'name',
        'description',
        'sku',
        'barcode',
        'category',
        'price',
        'cost',
        'stock',
        'min_stock',
        'supplier_id',
        'active'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[100]',
        'sku' => 'permit_empty|max_length[50]|is_unique[products.sku,id,{id}]',
        'barcode' => 'permit_empty|max_length[50]|is_unique[products.barcode,id,{id}]',
        'category' => 'required|max_length[50]',
        'price' => 'required|numeric|greater_than[0]',
        'cost' => 'permit_empty|numeric|greater_than_equal_to[0]',
        'stock' => 'required|integer|greater_than_equal_to[0]',
        'min_stock' => 'permit_empty|integer|greater_than_equal_to[0]'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'El nombre del producto es requerido',
            'min_length' => 'El nombre debe tener al menos 2 caracteres',
            'max_length' => 'El nombre no puede exceder 100 caracteres'
        ],
        'sku' => [
            'max_length' => 'El SKU no puede exceder 50 caracteres',
            'is_unique' => 'El SKU ya existe'
        ],
        'barcode' => [
            'max_length' => 'El código de barras no puede exceder 50 caracteres',
            'is_unique' => 'El código de barras ya existe'
        ],
        'category' => [
            'required' => 'La categoría es requerida',
            'max_length' => 'La categoría no puede exceder 50 caracteres'
        ],
        'price' => [
            'required' => 'El precio es requerido',
            'numeric' => 'El precio debe ser un número',
            'greater_than' => 'El precio debe ser mayor a 0'
        ],
        'cost' => [
            'numeric' => 'El costo debe ser un número',
            'greater_than_equal_to' => 'El costo debe ser mayor o igual a 0'
        ],
        'stock' => [
            'required' => 'El stock es requerido',
            'integer' => 'El stock debe ser un número entero',
            'greater_than_equal_to' => 'El stock debe ser mayor o igual a 0'
        ],
        'min_stock' => [
            'integer' => 'El stock mínimo debe ser un número entero',
            'greater_than_equal_to' => 'El stock mínimo debe ser mayor o igual a 0'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Métodos personalizados
    public function getActiveProducts()
    {
        return $this->where('active', 1)->findAll();
    }

    public function getProductsByCategory($category)
    {
        return $this->where('category', $category)
                    ->where('active', 1)
                    ->findAll();
    }

    public function searchProducts($term)
    {
        return $this->like('name', $term)
                    ->orLike('sku', $term)
                    ->orLike('barcode', $term)
                    ->orLike('description', $term)
                    ->where('active', 1)
                    ->findAll();
    }

    public function getLowStockProducts()
    {
        return $this->where('stock <= min_stock')
                    ->where('active', 1)
                    ->findAll();
    }

    public function getProductsWithSupplier()
    {
        return $this->select('products.*, suppliers.name as supplier_name')
                    ->join('suppliers', 'suppliers.id = products.supplier_id', 'left')
                    ->where('products.active', 1)
                    ->findAll();
    }

    public function updateStock($productId, $quantity)
    {
        $product = $this->find($productId);
        if ($product) {
            $newStock = $product['stock'] + $quantity;
            return $this->update($productId, ['stock' => $newStock]);
        }
        return false;
    }

    public function getProductByBarcode($barcode)
    {
        return $this->where('barcode', $barcode)
                    ->where('active', 1)
                    ->first();
    }

    public function getProductBySku($sku)
    {
        return $this->where('sku', $sku)
                    ->where('active', 1)
                    ->first();
    }

    public function getCategories()
    {
        return $this->distinct()
                    ->select('category')
                    ->where('active', 1)
                    ->findAll();
    }

    public function getProductStats()
    {
        $db = \Config\Database::connect();
        
        $stats = [
            'total_products' => $this->where('active', 1)->countAllResults(),
            'low_stock' => $this->where('stock <= min_stock')->where('active', 1)->countAllResults(),
            'out_of_stock' => $this->where('stock', 0)->where('active', 1)->countAllResults(),
            'total_value' => $this->selectSum('price * stock')->where('active', 1)->get()->getRow()->{'price * stock'} ?? 0
        ];

        return $stats;
    }
} 