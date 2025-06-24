<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'username',
        'password',
        'name',
        'email',
        'role',
        'active'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username,id,{id}]',
        'password' => 'required|min_length[6]',
        'name' => 'required|min_length[2]|max_length[100]',
        'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
        'role' => 'required|in_list[admin,user,cashier]'
    ];

    protected $validationMessages = [
        'username' => [
            'required' => 'El nombre de usuario es requerido',
            'min_length' => 'El nombre de usuario debe tener al menos 3 caracteres',
            'max_length' => 'El nombre de usuario no puede exceder 50 caracteres',
            'is_unique' => 'El nombre de usuario ya existe'
        ],
        'password' => [
            'required' => 'La contraseña es requerida',
            'min_length' => 'La contraseña debe tener al menos 6 caracteres'
        ],
        'name' => [
            'required' => 'El nombre es requerido',
            'min_length' => 'El nombre debe tener al menos 2 caracteres',
            'max_length' => 'El nombre no puede exceder 100 caracteres'
        ],
        'email' => [
            'required' => 'El email es requerido',
            'valid_email' => 'El email no es válido',
            'is_unique' => 'El email ya existe'
        ],
        'role' => [
            'required' => 'El rol es requerido',
            'in_list' => 'El rol debe ser admin, user o cashier'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (!isset($data['data']['password'])) {
            return $data;
        }

        // Solo hashear si no está hasheada
        if (strpos($data['data']['password'], '$2y$') !== 0) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    // Métodos personalizados
    public function getActiveUsers()
    {
        return $this->where('active', 1)->findAll();
    }

    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->where('active', 1)->first();
    }

    public function updateLastLogin($userId)
    {
        return $this->update($userId, ['last_login' => date('Y-m-d H:i:s')]);
    }

    public function getUsersByRole($role)
    {
        return $this->where('role', $role)->where('active', 1)->findAll();
    }
} 