<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - Salvatore POS</title>
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
                <a href="<?= base_url('sales') ?>" class="flex items-center px-4 py-3 text-white hover:bg-white hover:bg-opacity-20 rounded-lg transition duration-200">
                    <i class="fas fa-cash-register mr-3"></i>
                    <span>Ventas</span>
                </a>
                <a href="<?= base_url('products') ?>" class="flex items-center px-4 py-3 text-white hover:bg-white hover:bg-opacity-20 rounded-lg transition duration-200">
                    <i class="fas fa-box mr-3"></i>
                    <span>Productos</span>
                </a>
                <a href="<?= base_url('customers') ?>" class="flex items-center px-4 py-3 text-white bg-white bg-opacity-20 rounded-lg">
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
                        <i class="fas fa-users mr-3 text-blue-600"></i>
                        Clientes
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
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Clientes</p>
                            <p class="text-2xl font-semibold text-gray-900" id="totalCustomers">0</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Activos</p>
                            <p class="text-2xl font-semibold text-gray-900" id="activeCustomers">0</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                            <i class="fas fa-star text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Nuevos Hoy</p>
                            <p class="text-2xl font-semibold text-gray-900" id="newToday">0</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <i class="fas fa-chart-line text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Promedio Compra</p>
                            <p class="text-2xl font-semibold text-gray-900" id="avgPurchase">$0</p>
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
                                       placeholder="Buscar clientes..." 
                                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <button onclick="exportCustomers()" 
                                    class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                <i class="fas fa-download mr-2"></i>Exportar
                            </button>
                            <button onclick="openCustomerModal()" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <i class="fas fa-plus mr-2"></i>Nuevo Cliente
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customers Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Cliente
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Contacto
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ubicación
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Límite Crédito
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="customersTableBody">
                            <!-- Los clientes se cargarán dinámicamente aquí -->
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Customer Modal -->
    <div id="customerModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4" id="modalTitle">Nuevo Cliente</h3>
                <form id="customerForm">
                    <input type="hidden" id="customerId">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input type="text" id="customerName" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="customerEmail" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                            <input type="tel" id="customerPhone" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Dirección</label>
                            <textarea id="customerAddress" rows="2" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Ciudad</label>
                                <input type="text" id="customerCity" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Estado</label>
                                <input type="text" id="customerState" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Código Postal</label>
                                <input type="text" id="customerZipCode" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">País</label>
                                <input type="text" id="customerCountry" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Límite de Crédito</label>
                            <input type="number" id="customerCreditLimit" step="0.01" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="customerActive" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label class="ml-2 block text-sm text-gray-900">Activo</label>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeCustomerModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
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
        const customersUrl = '<?= base_url('customers/api') ?>';
        const dashboardUrl = '<?= base_url('dashboard') ?>';
        const logoutUrl = '<?= base_url('logout') ?>';

        // Variables globales
        let customers = [];
        let editingCustomer = null;

        // Inicializar la página
        document.addEventListener('DOMContentLoaded', function() {
            loadCustomers();
            setupEventListeners();
            updateCurrentTime();
            setInterval(updateCurrentTime, 1000);
        });

        function setupEventListeners() {
            // Búsqueda
            document.getElementById('searchInput').addEventListener('input', function(e) {
                filterCustomers(e.target.value);
            });

            // Formulario
            document.getElementById('customerForm').addEventListener('submit', function(e) {
                e.preventDefault();
                saveCustomer();
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

        function loadCustomers() {
            axios.get(customersUrl)
                .then(response => {
                    customers = response.data;
                    renderCustomers();
                    updateStats();
                })
                .catch(error => {
                    console.error('Error cargando clientes:', error);
                    showToast('Error cargando clientes', 'error');
                });
        }

        function renderCustomers() {
            const tbody = document.getElementById('customersTableBody');
            tbody.innerHTML = '';

            customers.forEach(customer => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50';
                
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-blue-300 flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">${customer.name}</div>
                                <div class="text-sm text-gray-500">${customer.tax_id || 'Sin ID fiscal'}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">${customer.email}</div>
                        <div class="text-sm text-gray-500">${customer.phone || 'Sin teléfono'}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">${customer.city || 'N/A'}, ${customer.state || 'N/A'}</div>
                        <div class="text-sm text-gray-500">${customer.country || 'N/A'}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        ${customer.credit_limit ? '$' + parseFloat(customer.credit_limit).toFixed(2) : 'Sin límite'}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full ${customer.active == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                            ${customer.active == 1 ? 'Activo' : 'Inactivo'}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button onclick="editCustomer(${customer.id})" class="text-blue-600 hover:text-blue-900 mr-3">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="deleteCustomer(${customer.id})" class="text-red-600 hover:text-red-900">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                
                tbody.appendChild(row);
            });
        }

        function updateStats() {
            const total = customers.length;
            const active = customers.filter(c => c.active == 1).length;
            const newToday = customers.filter(c => {
                const today = new Date().toISOString().split('T')[0];
                return c.created_at && c.created_at.startsWith(today);
            }).length;

            document.getElementById('totalCustomers').textContent = total;
            document.getElementById('activeCustomers').textContent = active;
            document.getElementById('newToday').textContent = newToday;
            document.getElementById('avgPurchase').textContent = '$0'; // Implementar cálculo real
        }

        function filterCustomers(searchTerm) {
            const filtered = customers.filter(customer => 
                customer.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
                customer.email.toLowerCase().includes(searchTerm.toLowerCase()) ||
                (customer.phone && customer.phone.includes(searchTerm)) ||
                (customer.tax_id && customer.tax_id.toLowerCase().includes(searchTerm.toLowerCase()))
            );
            renderFilteredCustomers(filtered);
        }

        function renderFilteredCustomers(filteredCustomers) {
            const tbody = document.getElementById('customersTableBody');
            tbody.innerHTML = '';

            filteredCustomers.forEach(customer => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50';
                
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-blue-300 flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">${customer.name}</div>
                                <div class="text-sm text-gray-500">${customer.tax_id || 'Sin ID fiscal'}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">${customer.email}</div>
                        <div class="text-sm text-gray-500">${customer.phone || 'Sin teléfono'}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">${customer.city || 'N/A'}, ${customer.state || 'N/A'}</div>
                        <div class="text-sm text-gray-500">${customer.country || 'N/A'}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        ${customer.credit_limit ? '$' + parseFloat(customer.credit_limit).toFixed(2) : 'Sin límite'}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full ${customer.active == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                            ${customer.active == 1 ? 'Activo' : 'Inactivo'}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button onclick="editCustomer(${customer.id})" class="text-blue-600 hover:text-blue-900 mr-3">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="deleteCustomer(${customer.id})" class="text-red-600 hover:text-red-900">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                
                tbody.appendChild(row);
            });
        }

        function openCustomerModal(customer = null) {
            editingCustomer = customer;
            const modal = document.getElementById('customerModal');
            const title = document.getElementById('modalTitle');
            const form = document.getElementById('customerForm');

            if (customer) {
                title.textContent = 'Editar Cliente';
                fillCustomerForm(customer);
            } else {
                title.textContent = 'Nuevo Cliente';
                form.reset();
            }

            modal.classList.remove('hidden');
        }

        function closeCustomerModal() {
            document.getElementById('customerModal').classList.add('hidden');
            editingCustomer = null;
        }

        function fillCustomerForm(customer) {
            document.getElementById('customerId').value = customer.id;
            document.getElementById('customerName').value = customer.name;
            document.getElementById('customerEmail').value = customer.email;
            document.getElementById('customerPhone').value = customer.phone || '';
            document.getElementById('customerAddress').value = customer.address || '';
            document.getElementById('customerCity').value = customer.city || '';
            document.getElementById('customerState').value = customer.state || '';
            document.getElementById('customerZipCode').value = customer.zip_code || '';
            document.getElementById('customerCountry').value = customer.country || '';
            document.getElementById('customerCreditLimit').value = customer.credit_limit || '';
            document.getElementById('customerActive').checked = customer.active == 1;
        }

        function saveCustomer() {
            const formData = {
                name: document.getElementById('customerName').value,
                email: document.getElementById('customerEmail').value,
                phone: document.getElementById('customerPhone').value,
                address: document.getElementById('customerAddress').value,
                city: document.getElementById('customerCity').value,
                state: document.getElementById('customerState').value,
                zip_code: document.getElementById('customerZipCode').value,
                country: document.getElementById('customerCountry').value,
                credit_limit: document.getElementById('customerCreditLimit').value || null,
                active: document.getElementById('customerActive').checked ? 1 : 0
            };

            const method = editingCustomer ? 'put' : 'post';
            const url = editingCustomer ? `${customersUrl}/${editingCustomer.id}` : customersUrl;

            axios[method](url, formData)
                .then(response => {
                    showToast(editingCustomer ? 'Cliente actualizado' : 'Cliente creado', 'success');
                    closeCustomerModal();
                    loadCustomers();
                })
                .catch(error => {
                    console.error('Error guardando cliente:', error);
                    showToast('Error guardando cliente', 'error');
                });
        }

        function editCustomer(id) {
            const customer = customers.find(c => c.id == id);
            if (customer) {
                openCustomerModal(customer);
            }
        }

        function deleteCustomer(id) {
            if (confirm('¿Estás seguro de que quieres eliminar este cliente?')) {
                axios.delete(`${customersUrl}/${id}`)
                    .then(response => {
                        showToast('Cliente eliminado', 'success');
                        loadCustomers();
                    })
                    .catch(error => {
                        console.error('Error eliminando cliente:', error);
                        showToast('Error eliminando cliente', 'error');
                    });
            }
        }

        function exportCustomers() {
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