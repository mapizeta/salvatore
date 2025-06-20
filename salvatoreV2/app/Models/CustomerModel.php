<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table = 'customers';
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
        'credit_limit',
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
        'email' => 'permit_empty|valid_email|is_unique[customers.email,id,{id}]',
        'phone' => 'permit_empty|max_length[20]',
        'address' => 'permit_empty|max_length[200]',
        'city' => 'permit_empty|max_length[50]',
        'state' => 'permit_empty|max_length[50]',
        'zip_code' => 'permit_empty|max_length[10]',
        'country' => 'permit_empty|max_length[50]',
        'tax_id' => 'permit_empty|max_length[50]|is_unique[customers.tax_id,id,{id}]',
        'credit_limit' => 'permit_empty|numeric|greater_than_equal_to[0]'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'El nombre del cliente es requerido',
            'min_length' => 'El nombre debe tener al menos 2 caracteres',
            'max_length' => 'El nombre no puede exceder 100 caracteres'
        ],
        'email' => [
            'valid_email' => 'El email no es válido',
            'is_unique' => 'El email ya existe'
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
            'max_length' => 'El ID fiscal no puede exceder 50 caracteres',
            'is_unique' => 'El ID fiscal ya existe'
        ],
        'credit_limit' => [
            'numeric' => 'El límite de crédito debe ser un número',
            'greater_than_equal_to' => 'El límite de crédito debe ser mayor o igual a 0'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Métodos personalizados
    public function getActiveCustomers()
    {
        return $this->where('active', 1)->findAll();
    }

    public function searchCustomers($term)
    {
        return $this->like('name', $term)
                    ->orLike('email', $term)
                    ->orLike('phone', $term)
                    ->orLike('tax_id', $term)
                    ->where('active', 1)
                    ->findAll();
    }

    public function getCustomerByEmail($email)
    {
        return $this->where('email', $email)
                    ->where('active', 1)
                    ->first();
    }

    public function getCustomerByTaxId($taxId)
    {
        return $this->where('tax_id', $taxId)
                    ->where('active', 1)
                    ->first();
    }

    public function getCustomersWithStats()
    {
        $db = \Config\Database::connect();
        $sql = "
            SELECT 
                c.*,
                COUNT(s.id) as total_sales,
                COALESCE(SUM(s.total), 0) as total_spent,
                MAX(s.created_at) as last_purchase
            FROM customers c
            LEFT JOIN sales s ON c.id = s.customer_id
            WHERE c.active = 1
            GROUP BY c.id
            ORDER BY c.name
        ";

        return $db->query($sql)->getResultArray();
    }

    public function getTopCustomers($limit = 10)
    {
        $db = \Config\Database::connect();
        $sql = "
            SELECT 
                c.id,
                c.name,
                c.email,
                COUNT(s.id) as total_sales,
                COALESCE(SUM(s.total), 0) as total_spent
            FROM customers c
            LEFT JOIN sales s ON c.id = s.customer_id
            WHERE c.active = 1
            GROUP BY c.id, c.name, c.email
            ORDER BY total_spent DESC
            LIMIT {$limit}
        ";

        return $db->query($sql)->getResultArray();
    }

    public function getNewCustomers($days = 30)
    {
        return $this->where('created_at >=', date('Y-m-d H:i:s', strtotime("-{$days} days")))
                    ->where('active', 1)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function getCustomerStats()
    {
        $stats = [
            'total_customers' => $this->where('active', 1)->countAllResults(),
            'new_this_month' => $this->where('MONTH(created_at)', date('m'))
                                    ->where('YEAR(created_at)', date('Y'))
                                    ->where('active', 1)
                                    ->countAllResults(),
            'new_this_week' => $this->where('created_at >=', date('Y-m-d H:i:s', strtotime('-7 days')))
                                   ->where('active', 1)
                                   ->countAllResults(),
            'new_today' => $this->where('DATE(created_at)', date('Y-m-d'))
                               ->where('active', 1)
                               ->countAllResults()
        ];

        return $stats;
    }

    public function getCustomersByLocation()
    {
        return $this->select('city, state, COUNT(*) as customer_count')
                    ->where('active', 1)
                    ->where('city IS NOT NULL')
                    ->where('city !=', '')
                    ->groupBy('city, state')
                    ->orderBy('customer_count', 'DESC')
                    ->findAll();
    }
} 