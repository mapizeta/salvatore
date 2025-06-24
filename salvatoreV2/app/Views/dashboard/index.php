<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Salvatore POS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <a href="/dashboard" class="flex items-center px-4 py-3 text-white bg-white bg-opacity-20 rounded-lg">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="sales" class="flex items-center px-4 py-3 text-white hover:bg-white hover:bg-opacity-20 rounded-lg transition duration-200">
                    <i class="fas fa-cash-register mr-3"></i>
                    <span>Ventas</span>
                </a>
                <a href="products" class="flex items-center px-4 py-3 text-white hover:bg-white hover:bg-opacity-20 rounded-lg transition duration-200">
                    <i class="fas fa-box mr-3"></i>
                    <span>Productos</span>
                </a>
                <a href="customers" class="flex items-center px-4 py-3 text-white hover:bg-white hover:bg-opacity-20 rounded-lg transition duration-200">
                    <i class="fas fa-users mr-3"></i>
                    <span>Clientes</span>
                </a>
                <a href="reports" class="flex items-center px-4 py-3 text-white hover:bg-white hover:bg-opacity-20 rounded-lg transition duration-200">
                    <i class="fas fa-chart-bar mr-3"></i>
                    <span>Reportes</span>
                </a>
                <a href="settings" class="flex items-center px-4 py-3 text-white hover:bg-white hover:bg-opacity-20 rounded-lg transition duration-200">
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
                <a href="/logout" class="text-white hover:text-red-400 transition duration-200">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="ml-64 transition-all duration-300 ease-in-out">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="flex items-center justify-between px-6 py-4">
                <div class="flex items-center space-x-4">
                    <button id="sidebarToggle" class="text-gray-500 hover:text-gray-700 lg:hidden">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
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

        <!-- Contenido del dashboard -->
        <main class="p-6">
            <!-- Tarjetas de estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Ventas del día -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Ventas del Día</p>
                            <p class="text-2xl font-bold text-gray-900" id="dailySales">$0</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-green-600 font-medium">+12%</span>
                        <span class="text-gray-500 ml-2">vs ayer</span>
                    </div>
                </div>

                <!-- Productos vendidos -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Productos Vendidos</p>
                            <p class="text-2xl font-bold text-gray-900" id="productsSold">0</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-box text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-blue-600 font-medium">+8%</span>
                        <span class="text-gray-500 ml-2">vs ayer</span>
                    </div>
                </div>

                <!-- Clientes nuevos -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Clientes Nuevos</p>
                            <p class="text-2xl font-bold text-gray-900" id="newCustomers">0</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-plus text-purple-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-purple-600 font-medium">+15%</span>
                        <span class="text-gray-500 ml-2">vs ayer</span>
                    </div>
                </div>

                <!-- Transacciones -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Transacciones</p>
                            <p class="text-2xl font-bold text-gray-900" id="transactions">0</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-receipt text-orange-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-orange-600 font-medium">+5%</span>
                        <span class="text-gray-500 ml-2">vs ayer</span>
                    </div>
                </div>
            </div>

            <!-- Gráficos y tablas -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Gráfico de ventas -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Ventas de la Semana</h3>
                    <canvas id="salesChart" width="400" height="200"></canvas>
                </div>

                <!-- Productos más vendidos -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Productos Más Vendidos</h3>
                    <div class="space-y-4" id="topProducts">
                        <!-- Los productos se cargarán dinámicamente -->
                    </div>
                </div>
            </div>

            <!-- Actividad reciente -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Actividad Reciente</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transacción</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Productos</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="recentActivity">
                            <!-- Las transacciones se cargarán dinámicamente -->
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Toggle sidebar en móviles
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const main = document.querySelector('.ml-64');
            
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                main.classList.remove('ml-0');
            } else {
                sidebar.classList.add('-translate-x-full');
                main.classList.add('ml-0');
            }
        });

        // Actualizar hora
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('es-ES', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('currentTime').textContent = timeString;
        }
        setInterval(updateTime, 1000);
        updateTime();

        // Cargar datos del dashboard
        async function loadDashboardData() {
            try {
                const response = await axios.get('/api/dashboard/stats');
                const data = response.data;

                // Actualizar estadísticas
                document.getElementById('dailySales').textContent = `$${data.dailySales.toFixed(2)}`;
                document.getElementById('productsSold').textContent = data.productsSold;
                document.getElementById('newCustomers').textContent = data.newCustomers;
                document.getElementById('transactions').textContent = data.transactions;

                // Actualizar gráfico
                updateSalesChart(data.weeklySales);

                // Actualizar productos más vendidos
                updateTopProducts(data.topProducts);

                // Actualizar actividad reciente
                updateRecentActivity(data.recentActivity);

            } catch (error) {
                console.error('Error cargando datos del dashboard:', error);
                Toastify({
                    text: "Error cargando datos del dashboard",
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#ef4444",
                    stopOnFocus: true
                }).showToast();
            }
        }

        // Actualizar gráfico de ventas
        function updateSalesChart(weeklySales) {
            const ctx = document.getElementById('salesChart').getContext('2d');
            
            if (window.salesChart) {
                window.salesChart.destroy();
            }

            window.salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: weeklySales.map(item => item.day),
                    datasets: [{
                        label: 'Ventas ($)',
                        data: weeklySales.map(item => item.sales),
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '$' + value;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Actualizar productos más vendidos
        function updateTopProducts(products) {
            const container = document.getElementById('topProducts');
            container.innerHTML = '';

            products.forEach((product, index) => {
                const productElement = document.createElement('div');
                productElement.className = 'flex items-center space-x-4';
                productElement.innerHTML = `
                    <div class="flex-shrink-0 w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                        <span class="text-sm font-medium text-gray-600">${index + 1}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">${product.name}</p>
                        <p class="text-sm text-gray-500">${product.category}</p>
                    </div>
                    <div class="flex-shrink-0">
                        <p class="text-sm font-medium text-gray-900">${product.quantity} vendidos</p>
                    </div>
                `;
                container.appendChild(productElement);
            });
        }

        // Actualizar actividad reciente
        function updateRecentActivity(activity) {
            const container = document.getElementById('recentActivity');
            container.innerHTML = '';

            activity.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        #${item.id}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        ${item.customer}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${item.products} productos
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        $${item.total.toFixed(2)}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full ${item.status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'}">
                            ${item.status === 'completed' ? 'Completada' : 'Pendiente'}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${new Date(item.date).toLocaleDateString('es-ES')}
                    </td>
                `;
                container.appendChild(row);
            });
        }

        // Cargar datos al iniciar
        document.addEventListener('DOMContentLoaded', function() {
            loadDashboardData();
            
            // Recargar datos cada 5 minutos
            setInterval(loadDashboardData, 300000);
        });
    </script>
</body>
</html> 