<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas - Salvatore POS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>
<body class="bg-gray-100">
    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-blue-900 to-purple-900 transform transition-transform duration-300 ease-in-out" id="sidebar">
        <!-- Logo -->
        <div class="flex items-center justify-center h-16 bg-black bg-opacity-20">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                    <i class="fas fa-store text-blue-600 text-xl"></i>
                </div>
                <span class="text-white font-bold text-xl">Salvatore</span>
            </div>
        </div>

        <!-- Menú -->
        <nav class="mt-8 px-4">
            <div class="space-y-2">
                <a href="<?= base_url('dashboard') ?>" class="flex items-center px-4 py-3 text-white hover:bg-white hover:bg-opacity-20 rounded-lg transition duration-200">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="<?= base_url('sales') ?>" class="flex items-center px-4 py-3 text-white bg-white bg-opacity-20 rounded-lg">
                    <i class="fas fa-cash-register mr-3"></i>
                    <span>Ventas</span>
                </a>
                <a href="<?= base_url('products') ?>" class="flex items-center px-4 py-3 text-white hover:bg-white hover:bg-opacity-20 rounded-lg transition duration-200">
                    <i class="fas fa-box mr-3"></i>
                    <span>Productos</span>
                </a>
                <a href="<?= base_url('customers') ?>" class="flex items-center px-4 py-3 text-white hover:bg-white hover:bg-opacity-20 rounded-lg transition duration-200">
                    <i class="fas fa-users mr-3"></i>
                    <span>Clientes</span>
                </a>
                <a href="<?= base_url('reports') ?>" class="flex items-center px-4 py-3 text-white hover:bg-white hover:bg-opacity-20 rounded-lg transition duration-200">
                    <i class="fas fa-chart-bar mr-3"></i>
                    <span>Reportes</span>
                </a>
                <a href="<?= base_url('settings') ?>" class="flex items-center px-4 py-3 text-white hover:bg-white hover:bg-opacity-20 rounded-lg transition duration-200">
                    <i class="fas fa-cog mr-3"></i>
                    <span>Configuración</span>
                </a>
            </div>
        </nav>

        <!-- Usuario -->
        <div class="absolute bottom-0 left-0 right-0 p-4">
            <div class="flex items-center space-x-3 bg-black bg-opacity-20 rounded-lg p-3">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-blue-600"></i>
                </div>
                <div class="flex-1">
                    <p class="text-white font-medium"><?= session()->get('username') ?? 'Usuario' ?></p>
                    <p class="text-gray-300 text-sm">Administrador</p>
                </div>
                <a href="<?= base_url('logout') ?>" class="text-white hover:text-red-400 transition duration-200">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="lg:ml-64 transition-all duration-300 ease-in-out">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="flex items-center justify-between px-6 py-4">
                <div class="flex items-center space-x-4">
                    <button id="sidebarToggle" class="text-gray-500 hover:text-gray-700 lg:hidden">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-2xl font-bold text-gray-800">
                        <i class="fas fa-cash-register mr-3 text-blue-600"></i>
                        Ventas
                    </h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-clock mr-2"></i>
                        <span id="currentTime"></span>
                    </div>
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-bell text-blue-600"></i>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="p-6">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-dollar-sign text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Ventas del Día</p>
                            <p class="text-2xl font-semibold text-gray-900" id="dailySales">$0</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-receipt text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Transacciones</p>
                            <p class="text-2xl font-semibold text-gray-900" id="totalTransactions">0</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <i class="fas fa-shopping-cart text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Items Vendidos</p>
                            <p class="text-2xl font-semibold text-gray-900" id="itemsSold">0</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Clientes Atendidos</p>
                            <p class="text-2xl font-semibold text-gray-900" id="customersServed">0</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions Bar -->
            <div class="bg-white rounded-lg shadow mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                        <div class="flex-1">
                            <div class="relative">
                                <input type="text" 
                                       id="searchInput" 
                                       placeholder="Buscar ventas..." 
                                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <button onclick="exportSales()" 
                                    class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                <i class="fas fa-download mr-2"></i>Exportar
                            </button>
                            <button onclick="openSaleModal()" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <i class="fas fa-plus mr-2"></i>Nueva Venta
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sales Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Venta
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Cliente
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Items
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Método Pago
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="salesTableBody">
                            <!-- Las ventas se cargarán dinámicamente aquí -->
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Sale Modal -->
    <div id="saleModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4" id="modalTitle">Nueva Venta</h3>
                <form id="saleForm">
                    <input type="hidden" id="saleId">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cliente</label>
                            <select id="saleCustomer" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Seleccionar cliente</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Productos</label>
                            <div id="saleItems" class="space-y-2">
                                <div class="flex space-x-2">
                                    <select class="flex-1 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Producto</option>
                                    </select>
                                    <input type="number" placeholder="Cant." min="1" class="w-20 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <button type="button" onclick="addSaleItem()" class="px-3 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Subtotal</label>
                                <input type="text" id="saleSubtotal" readonly class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Total</label>
                                <input type="text" id="saleTotal" readonly class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Método de Pago</label>
                            <select id="salePaymentMethod" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="cash">Efectivo</option>
                                <option value="card">Tarjeta</option>
                                <option value="transfer">Transferencia</option>
                            </select>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="saleCompleted" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label class="ml-2 block text-sm text-gray-900">Venta Completada</label>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeSaleModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            Cancelar
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // URLs del sistema
        const salesUrl = '<?= base_url('sales/api') ?>';
        const customersUrl = '<?= base_url('customers/api') ?>';
        const productsUrl = '<?= base_url('products/api') ?>';
        const dashboardUrl = '<?= base_url('dashboard') ?>';
        const logoutUrl = '<?= base_url('logout') ?>';

        // Variables globales
        let sales = [];
        let customers = [];
        let products = [];
        let editingSale = null;

        // Inicializar la página
        document.addEventListener('DOMContentLoaded', function() {
            loadSales();
            loadCustomers();
            loadProducts();
            setupEventListeners();
            updateCurrentTime();
            setInterval(updateCurrentTime, 1000);
        });

        function setupEventListeners() {
            // Búsqueda
            document.getElementById('searchInput').addEventListener('input', function(e) {
                filterSales(e.target.value);
            });

            // Formulario
            document.getElementById('saleForm').addEventListener('submit', function(e) {
                e.preventDefault();
                saveSale();
            });

            // Sidebar toggle
            document.getElementById('sidebarToggle').addEventListener('click', function() {
                toggleSidebar();
            });
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            
            if (sidebar.classList.contains('-translate-x-full')) {
                // Mostrar sidebar
                sidebar.classList.remove('-translate-x-full');
            } else {
                // Ocultar sidebar
                sidebar.classList.add('-translate-x-full');
            }
        }

        function updateCurrentTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('es-ES', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('currentTime').textContent = timeString;
        }

        function loadSales() {
            axios.get(salesUrl)
                .then(response => {
                    sales = response.data;
                    renderSales();
                    updateStats();
                })
                .catch(error => {
                    console.error('Error cargando ventas:', error);
                    showToast('Error cargando ventas', 'error');
                });
        }

        function loadCustomers() {
            axios.get(customersUrl)
                .then(response => {
                    customers = response.data;
                })
                .catch(error => {
                    console.error('Error cargando clientes:', error);
                });
        }

        function loadProducts() {
            axios.get(productsUrl)
                .then(response => {
                    products = response.data;
                })
                .catch(error => {
                    console.error('Error cargando productos:', error);
                });
        }

        function renderSales() {
            const tbody = document.getElementById('salesTableBody');
            tbody.innerHTML = '';

            sales.forEach(sale => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50';
                
                const customer = customers.find(c => c.id == sale.customer_id);
                const paymentMethod = getPaymentMethodText(sale.payment_method);
                const status = getStatusText(sale.status);
                
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">#${sale.id}</div>
                        <div class="text-sm text-gray-500">${sale.reference || 'Sin referencia'}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">${customer ? customer.name : 'Cliente no encontrado'}</div>
                        <div class="text-sm text-gray-500">${customer ? customer.email : ''}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        ${sale.items_count || 0} items
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        $${parseFloat(sale.total).toFixed(2)}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            ${paymentMethod}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full ${status.class}">
                            ${status.text}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        ${formatDate(sale.created_at)}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button onclick="viewSale(${sale.id})" class="text-blue-600 hover:text-blue-900 mr-3">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button onclick="editSale(${sale.id})" class="text-green-600 hover:text-green-900 mr-3">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="deleteSale(${sale.id})" class="text-red-600 hover:text-red-900">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                
                tbody.appendChild(row);
            });
        }

        function getPaymentMethodText(method) {
            const methods = {
                'cash': 'Efectivo',
                'card': 'Tarjeta',
                'transfer': 'Transferencia'
            };
            return methods[method] || method;
        }

        function getStatusText(status) {
            if (status == 1) {
                return { class: 'bg-green-100 text-green-800', text: 'Completada' };
            } else {
                return { class: 'bg-yellow-100 text-yellow-800', text: 'Pendiente' };
            }
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('es-ES', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        function updateStats() {
            const today = new Date().toISOString().split('T')[0];
            const todaySales = sales.filter(s => s.created_at && s.created_at.startsWith(today));
            
            const dailyTotal = todaySales.reduce((sum, sale) => sum + parseFloat(sale.total), 0);
            const totalTransactions = sales.length;
            const itemsSold = sales.reduce((sum, sale) => sum + (sale.items_count || 0), 0);
            const uniqueCustomers = new Set(sales.map(s => s.customer_id)).size;

            document.getElementById('dailySales').textContent = '$' + dailyTotal.toFixed(2);
            document.getElementById('totalTransactions').textContent = totalTransactions;
            document.getElementById('itemsSold').textContent = itemsSold;
            document.getElementById('customersServed').textContent = uniqueCustomers;
        }

        function filterSales(searchTerm) {
            const filtered = sales.filter(sale => {
                const customer = customers.find(c => c.id == sale.customer_id);
                return sale.id.toString().includes(searchTerm) ||
                       (customer && customer.name.toLowerCase().includes(searchTerm.toLowerCase())) ||
                       sale.reference?.toLowerCase().includes(searchTerm.toLowerCase());
            });
            renderFilteredSales(filtered);
        }

        function renderFilteredSales(filteredSales) {
            const tbody = document.getElementById('salesTableBody');
            tbody.innerHTML = '';

            filteredSales.forEach(sale => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50';
                
                const customer = customers.find(c => c.id == sale.customer_id);
                const paymentMethod = getPaymentMethodText(sale.payment_method);
                const status = getStatusText(sale.status);
                
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">#${sale.id}</div>
                        <div class="text-sm text-gray-500">${sale.reference || 'Sin referencia'}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">${customer ? customer.name : 'Cliente no encontrado'}</div>
                        <div class="text-sm text-gray-500">${customer ? customer.email : ''}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        ${sale.items_count || 0} items
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        $${parseFloat(sale.total).toFixed(2)}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            ${paymentMethod}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full ${status.class}">
                            ${status.text}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        ${formatDate(sale.created_at)}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button onclick="viewSale(${sale.id})" class="text-blue-600 hover:text-blue-900 mr-3">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button onclick="editSale(${sale.id})" class="text-green-600 hover:text-green-900 mr-3">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="deleteSale(${sale.id})" class="text-red-600 hover:text-red-900">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                
                tbody.appendChild(row);
            });
        }

        function openSaleModal(sale = null) {
            editingSale = sale;
            const modal = document.getElementById('saleModal');
            const title = document.getElementById('modalTitle');
            const form = document.getElementById('saleForm');

            if (sale) {
                title.textContent = 'Editar Venta';
                fillSaleForm(sale);
            } else {
                title.textContent = 'Nueva Venta';
                form.reset();
                populateCustomerSelect();
            }

            modal.classList.remove('hidden');
        }

        function closeSaleModal() {
            document.getElementById('saleModal').classList.add('hidden');
            editingSale = null;
        }

        function populateCustomerSelect() {
            const select = document.getElementById('saleCustomer');
            select.innerHTML = '<option value="">Seleccionar cliente</option>';
            
            customers.forEach(customer => {
                const option = document.createElement('option');
                option.value = customer.id;
                option.textContent = customer.name;
                select.appendChild(option);
            });
        }

        function fillSaleForm(sale) {
            document.getElementById('saleId').value = sale.id;
            document.getElementById('saleCustomer').value = sale.customer_id;
            document.getElementById('salePaymentMethod').value = sale.payment_method;
            document.getElementById('saleCompleted').checked = sale.status == 1;
            // Implementar llenado de items
        }

        function addSaleItem() {
            const itemsContainer = document.getElementById('saleItems');
            const newItem = document.createElement('div');
            newItem.className = 'flex space-x-2';
            newItem.innerHTML = `
                <select class="flex-1 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Producto</option>
                    ${products.map(p => `<option value="${p.id}">${p.name} - $${p.price}</option>`).join('')}
                </select>
                <input type="number" placeholder="Cant." min="1" class="w-20 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <button type="button" onclick="removeSaleItem(this)" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    <i class="fas fa-minus"></i>
                </button>
            `;
            itemsContainer.appendChild(newItem);
        }

        function removeSaleItem(button) {
            button.parentElement.remove();
        }

        function saveSale() {
            // Implementar guardado de venta
            showToast('Función de guardado en desarrollo', 'info');
            closeSaleModal();
        }

        function viewSale(id) {
            // Implementar vista de venta
            showToast('Función de vista en desarrollo', 'info');
        }

        function editSale(id) {
            const sale = sales.find(s => s.id == id);
            if (sale) {
                openSaleModal(sale);
            }
        }

        function deleteSale(id) {
            if (confirm('¿Estás seguro de que quieres eliminar esta venta?')) {
                axios.delete(`${salesUrl}/${id}`)
                    .then(response => {
                        showToast('Venta eliminada', 'success');
                        loadSales();
                    })
                    .catch(error => {
                        console.error('Error eliminando venta:', error);
                        showToast('Error eliminando venta', 'error');
                    });
            }
        }

        function exportSales() {
            // Implementar exportación
            showToast('Función de exportación en desarrollo', 'info');
        }

        function showToast(message, type = 'info') {
            const backgroundColor = type === 'success' ? '#10b981' : 
                                  type === 'error' ? '#ef4444' : 
                                  type === 'warning' ? '#f59e0b' : '#3b82f6';

            Toastify({
                text: message,
                duration: 3000,
                gravity: "top",
                position: "right",
                backgroundColor: backgroundColor,
                stopOnFocus: true
            }).showToast();
        }
    </script>
</body>
</html> 