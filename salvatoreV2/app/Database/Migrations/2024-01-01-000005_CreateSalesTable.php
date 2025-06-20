<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSalesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'customer_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'total' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'tax' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'discount' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'payment_method' => [
                'type' => 'ENUM',
                'constraint' => ['cash', 'card', 'transfer'],
                'default' => 'cash',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'completed', 'cancelled'],
                'default' => 'completed',
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('customer_id', 'customers', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('sales');
    }

    public function down()
    {
        $this->forge->dropTable('sales');
    }
} 