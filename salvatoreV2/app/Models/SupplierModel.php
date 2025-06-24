<?php

namespace App\Models;

use CodeIgniter\Model;

class SupplierModel extends Model
{
    protected $table = 'suppliers';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'tax_id',
        'contact_person',
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
        'email' => 'permit_empty|valid_email',
        'phone' => 'permit_empty|max_length[20]',
        'address' => 'permit_empty|max_length[200]',
        'city' => 'permit_empty|max_length[50]',
        'state' => 'permit_empty|max_length[50]',
        'zip_code' => 'permit_empty|max_length[10]',
        'country' => 'permit_empty|max_length[50]',
        'tax_id' => 'permit_empty|max_length[50]',
        'contact_person' => 'permit_empty|max_length[100]'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'El nombre del proveedor es requerido',
            'min_length' => 'El nombre debe tener al menos 2 caracteres',
            'max_length' => 'El nombre no puede exceder 100 caracteres'
        ],
        'email' => [
            'valid_email' => 'El email no es válido'
        ],
        'phone' => [
            'max_length' => 'El teléfono no puede exceder 20 caracteres'
        ],
        'address' => [
            'max_length' => 'La dirección no puede exceder 200 caracteres'
        ],
        'city' => [
            'max_length' => 'La ciudad no puede exceder 50 caracteres'
        ],
        'state' => [
            'max_length' => 'El estado no puede exceder 50 caracteres'
        ],
        'zip_code' => [
            'max_length' => 'El código postal no puede exceder 10 caracteres'
        ],
        'country' => [
            'max_length' => 'El país no puede exceder 50 caracteres'
        ],
        'tax_id' => [
            'max_length' => 'El ID fiscal no puede exceder 50 caracteres'
        ],
        'contact_person' => [
            'max_length' => 'El nombre de contacto no puede exceder 100 caracteres'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Métodos personalizados
    public function getActiveSuppliers()
    {
        return $this->where('active', 1)->findAll();
    }

    public function searchSuppliers($term)
    {
        return $this->like('name', $term)
                    ->orLike('email', $term)
                    ->orLike('phone', $term)
                    ->orLike('contact_person', $term)
                    ->where('active', 1)
                    ->findAll();
    }

    public function getSupplierByEmail($email)
    {
        return $this->where('email', $email)
                    ->where('active', 1)
                    ->first();
    }

    public function getSuppliersWithStats()
    {
        $db = \Config\Database::connect();
        $sql = "
            SELECT 
                s.*,
                COUNT(p.id) as total_products,
                COALESCE(SUM(p.stock * p.cost), 0) as inventory_value
            FROM suppliers s
            LEFT JOIN products p ON s.id = p.supplier_id AND p.active = 1
            WHERE s.active = 1
            GROUP BY s.id
            ORDER BY s.name
        ";

        return $db->query($sql)->getResultArray();
    }

    public function getSupplierStats()
    {
        $stats = [
            'total_suppliers' => $this->where('active', 1)->countAllResults(),
            'suppliers_with_products' => $this->select('DISTINCT suppliers.id')
                                             ->join('products', 'products.supplier_id = suppliers.id')
                                             ->where('suppliers.active', 1)
                                             ->where('products.active', 1)
                                             ->countAllResults()
        ];

        return $stats;
    }
} 