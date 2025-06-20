<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductsTable extends Migration
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
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'sku' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'barcode' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'category' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'cost' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'stock' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'min_stock' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'supplier_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
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
        $this->forge->addUniqueKey('sku');
        $this->forge->addUniqueKey('barcode');
        $this->forge->addForeignKey('supplier_id', 'suppliers', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
} 