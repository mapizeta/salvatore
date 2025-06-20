<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Rutas de autenticación
$routes->get('login', 'Auth::index');
$routes->post('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');
$routes->get('auth/check', 'Auth::checkAuth');

// Rutas principales
$routes->get('/', 'Auth::index');

// Rutas protegidas (requieren autenticación)
$routes->group('', ['filter' => 'auth'], function($routes) {
    // Dashboard
    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('api/dashboard/stats', 'Dashboard::getStats');
    
    // Rutas de productos
    $routes->group('products', function($routes) {
        $routes->get('/', 'Products::index');
        $routes->get('api', 'Products::getProducts');
        $routes->post('api', 'Products::create');
        $routes->put('api/(:num)', 'Products::update/$1');
        $routes->delete('api/(:num)', 'Products::delete/$1');
    });

    // Rutas de clientes
    $routes->group('customers', function($routes) {
        $routes->get('/', 'Customers::index');
        $routes->get('api', 'Customers::getCustomers');
        $routes->post('api', 'Customers::create');
        $routes->put('api/(:num)', 'Customers::update/$1');
        $routes->delete('api/(:num)', 'Customers::delete/$1');
    });

    // Rutas de ventas
    $routes->group('sales', function($routes) {
        $routes->get('/', 'Sales::index');
        $routes->get('api', 'Sales::getSales');
        $routes->post('api', 'Sales::create');
        $routes->get('api/(:num)', 'Sales::getSale/$1');
        $routes->put('api/(:num)', 'Sales::update/$1');
        $routes->delete('api/(:num)', 'Sales::delete/$1');
    });

    // Rutas de reportes
    $routes->group('reports', function($routes) {
        $routes->get('/', 'Reports::index');
        $routes->get('sales', 'Reports::sales');
        $routes->get('products', 'Reports::products');
        $routes->get('customers', 'Reports::customers');
    });
});
