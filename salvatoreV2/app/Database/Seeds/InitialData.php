<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialData extends Seeder
{
    public function run()
    {
        // Crear usuario administrador
        $userModel = new \App\Models\UserModel();
        $userModel->insert([
            'username' => 'admin',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'name' => 'Administrador',
            'email' => 'admin@salvatore.com',
            'role' => 'admin',
            'active' => 1
        ]);

        // Crear proveedor de ejemplo
        $supplierModel = new \App\Models\SupplierModel();
        $supplierModel->insert([
            'name' => 'Proveedor General',
            'email' => 'info@proveedor.com',
            'phone' => '+1234567890',
            'address' => 'Calle Principal 123',
            'city' => 'Ciudad',
            'state' => 'Estado',
            'zip_code' => '12345',
            'country' => 'País',
            'contact_person' => 'Juan Pérez',
            'active' => 1
        ]);

        // Crear productos de ejemplo
        $productModel = new \App\Models\ProductModel();
        $products = [
            [
                'name' => 'Laptop HP Pavilion',
                'description' => 'Laptop de 15 pulgadas con procesador Intel i5',
                'sku' => 'LAP001',
                'barcode' => '1234567890123',
                'category' => 'Electrónicos',
                'price' => 899.99,
                'cost' => 650.00,
                'stock' => 10,
                'min_stock' => 2,
                'supplier_id' => 1,
                'active' => 1
            ],
            [
                'name' => 'Mouse Inalámbrico Logitech',
                'description' => 'Mouse inalámbrico con sensor óptico',
                'sku' => 'MOU001',
                'barcode' => '1234567890124',
                'category' => 'Accesorios',
                'price' => 29.99,
                'cost' => 15.00,
                'stock' => 50,
                'min_stock' => 10,
                'supplier_id' => 1,
                'active' => 1
            ],
            [
                'name' => 'Teclado Mecánico RGB',
                'description' => 'Teclado mecánico con switches Cherry MX',
                'sku' => 'TEC001',
                'barcode' => '1234567890125',
                'category' => 'Accesorios',
                'price' => 149.99,
                'cost' => 80.00,
                'stock' => 25,
                'min_stock' => 5,
                'supplier_id' => 1,
                'active' => 1
            ],
            [
                'name' => 'Monitor Samsung 24"',
                'description' => 'Monitor LED de 24 pulgadas Full HD',
                'sku' => 'MON001',
                'barcode' => '1234567890126',
                'category' => 'Electrónicos',
                'price' => 199.99,
                'cost' => 120.00,
                'stock' => 15,
                'min_stock' => 3,
                'supplier_id' => 1,
                'active' => 1
            ],
            [
                'name' => 'Auriculares Sony WH-1000XM4',
                'description' => 'Auriculares inalámbricos con cancelación de ruido',
                'sku' => 'AUR001',
                'barcode' => '1234567890127',
                'category' => 'Audio',
                'price' => 349.99,
                'cost' => 200.00,
                'stock' => 8,
                'min_stock' => 2,
                'supplier_id' => 1,
                'active' => 1
            ]
        ];

        foreach ($products as $product) {
            $productModel->insert($product);
        }

        // Crear clientes de ejemplo
        $customerModel = new \App\Models\CustomerModel();
        $customers = [
            [
                'name' => 'Cliente General',
                'email' => 'cliente@ejemplo.com',
                'phone' => '+1234567890',
                'address' => 'Calle Cliente 456',
                'city' => 'Ciudad Cliente',
                'state' => 'Estado Cliente',
                'zip_code' => '54321',
                'country' => 'País Cliente',
                'active' => 1
            ],
            [
                'name' => 'Empresa ABC',
                'email' => 'contacto@empresaabc.com',
                'phone' => '+1234567891',
                'address' => 'Av. Empresa 789',
                'city' => 'Ciudad Empresa',
                'state' => 'Estado Empresa',
                'zip_code' => '67890',
                'country' => 'País Empresa',
                'tax_id' => 'ABC123456',
                'credit_limit' => 5000.00,
                'active' => 1
            ]
        ];

        foreach ($customers as $customer) {
            $customerModel->insert($customer);
        }

        // Crear ventas de ejemplo
        $saleModel = new \App\Models\SaleModel();
        $saleItemModel = new \App\Models\SaleItemModel();

        // Venta 1
        $sale1 = $saleModel->insert([
            'customer_id' => 1,
            'user_id' => 1,
            'total' => 929.98,
            'tax' => 0.00,
            'discount' => 0.00,
            'payment_method' => 'cash',
            'status' => 'completed'
        ]);

        $saleItemModel->insert([
            'sale_id' => $sale1,
            'product_id' => 1,
            'quantity' => 1,
            'price' => 899.99,
            'discount' => 0.00,
            'total' => 899.99
        ]);

        $saleItemModel->insert([
            'sale_id' => $sale1,
            'product_id' => 2,
            'quantity' => 1,
            'price' => 29.99,
            'discount' => 0.00,
            'total' => 29.99
        ]);

        // Venta 2
        $sale2 = $saleModel->insert([
            'customer_id' => 2,
            'user_id' => 1,
            'total' => 549.98,
            'tax' => 0.00,
            'discount' => 0.00,
            'payment_method' => 'card',
            'status' => 'completed'
        ]);

        $saleItemModel->insert([
            'sale_id' => $sale2,
            'product_id' => 3,
            'quantity' => 1,
            'price' => 149.99,
            'discount' => 0.00,
            'total' => 149.99
        ]);

        $saleItemModel->insert([
            'sale_id' => $sale2,
            'product_id' => 4,
            'quantity' => 2,
            'price' => 199.99,
            'discount' => 0.00,
            'total' => 399.98
        ]);

        // Actualizar stock de productos
        $productModel->update(1, ['stock' => 9]); // Laptop
        $productModel->update(2, ['stock' => 49]); // Mouse
        $productModel->update(3, ['stock' => 24]); // Teclado
        $productModel->update(4, ['stock' => 13]); // Monitor

        echo "Datos iniciales creados exitosamente.\n";
    }
} 