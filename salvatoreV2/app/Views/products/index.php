<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Salvatore POS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>
<body class="bg-gray-100">
    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-blue-900 to-purple-900 transform transition-transform duration-300 ease-in-out lg:translate-x-0 -translate-x-full" id="sidebar">
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
                <a href="<?= base_url('products') ?>" class="flex items-center px-4 py-3 text-white bg-white bg-opacity-20 rounded-lg">
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
                    <button id="sidebarToggle" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-2xl font-bold text-gray-800">
                        <i class="fas fa-boxes mr-3 text-blue-600"></i>
                        Productos
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
                            <i class="fas fa-boxes text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Productos</p>
                            <p class="text-2xl font-semibold text-gray-900" id="totalProducts">0</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">En Stock</p>
                            <p class="text-2xl font-semibold text-gray-900" id="inStock">0</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                            <i class="fas fa-exclamation-triangle text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Stock Bajo</p>
                            <p class="text-2xl font-semibold text-gray-900" id="lowStock">0</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 text-red-600">
                            <i class="fas fa-times-circle text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Sin Stock</p>
                            <p class="text-2xl font-semibold text-gray-900" id="outOfStock">0</p>
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
                                       placeholder="Buscar productos..." 
                                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <button onclick="exportProducts()" 
                                    class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                <i class="fas fa-download mr-2"></i>Exportar
                            </button>
                            <button onclick="openProductModal()" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <i class="fas fa-plus mr-2"></i>Nuevo Producto
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Producto
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Categoría
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    SKU
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Precio
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Stock
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="productsTableBody">
                            <!-- Los productos se cargarán dinámicamente aquí -->
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Product Modal -->
    <div id="productModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4" id="modalTitle">Nuevo Producto</h3>
                <form id="productForm">
                    <input type="hidden" id="productId">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input type="text" id="productName" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Descripción</label>
                            <textarea id="productDescription" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">SKU</label>
                                <input type="text" id="productSku" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Categoría</label>
                                <input type="text" id="productCategory" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Precio</label>
                                <input type="number" id="productPrice" step="0.01" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Stock</label>
                                <input type="number" id="productStock" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="productActive" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label class="ml-2 block text-sm text-gray-900">Activo</label>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeProductModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
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
        const productsUrl = '<?= base_url('products/api') ?>';
        const dashboardUrl = '<?= base_url('dashboard') ?>';
        const logoutUrl = '<?= base_url('logout') ?>';

        // Variables globales
        let products = [];
        let editingProduct = null;

        // Inicializar la página
        document.addEventListener('DOMContentLoaded', function() {
            loadProducts();
            setupEventListeners();
            updateCurrentTime();
            setInterval(updateCurrentTime, 1000);
        });

        function setupEventListeners() {
            // Búsqueda
            document.getElementById('searchInput').addEventListener('input', function(e) {
                filterProducts(e.target.value);
            });

            // Formulario
            document.getElementById('productForm').addEventListener('submit', function(e) {
                e.preventDefault();
                saveProduct();
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

        function loadProducts() {
            axios.get(productsUrl)
                .then(response => {
                    products = response.data;
                    renderProducts();
                    updateStats();
                })
                .catch(error => {
                    console.error('Error cargando productos:', error);
                    showToast('Error cargando productos', 'error');
                });
        }

        function renderProducts() {
            const tbody = document.getElementById('productsTableBody');
            tbody.innerHTML = '';

            products.forEach(product => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50';
                
                const stockStatus = getStockStatus(product.stock, product.min_stock);
                
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                    <i class="fas fa-box text-gray-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">${product.name}</div>
                                <div class="text-sm text-gray-500">${product.description || 'Sin descripción'}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            ${product.category}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${product.sku}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$${parseFloat(product.price).toFixed(2)}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${product.stock}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full ${stockStatus.class}">
                            ${stockStatus.text}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button onclick="editProduct(${product.id})" class="text-blue-600 hover:text-blue-900 mr-3">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="deleteProduct(${product.id})" class="text-red-600 hover:text-red-900">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                
                tbody.appendChild(row);
            });
        }

        function getStockStatus(stock, minStock) {
            if (stock <= 0) {
                return { class: 'bg-red-100 text-red-800', text: 'Sin Stock' };
            } else if (stock <= minStock) {
                return { class: 'bg-yellow-100 text-yellow-800', text: 'Stock Bajo' };
            } else {
                return { class: 'bg-green-100 text-green-800', text: 'En Stock' };
            }
        }

        function updateStats() {
            const total = products.length;
            const inStock = products.filter(p => p.stock > p.min_stock).length;
            const lowStock = products.filter(p => p.stock > 0 && p.stock <= p.min_stock).length;
            const outOfStock = products.filter(p => p.stock <= 0).length;

            document.getElementById('totalProducts').textContent = total;
            document.getElementById('inStock').textContent = inStock;
            document.getElementById('lowStock').textContent = lowStock;
            document.getElementById('outOfStock').textContent = outOfStock;
        }

        function filterProducts(searchTerm) {
            const filtered = products.filter(product => 
                product.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
                product.sku.toLowerCase().includes(searchTerm.toLowerCase()) ||
                product.category.toLowerCase().includes(searchTerm.toLowerCase())
            );
            renderFilteredProducts(filtered);
        }

        function renderFilteredProducts(filteredProducts) {
            const tbody = document.getElementById('productsTableBody');
            tbody.innerHTML = '';

            filteredProducts.forEach(product => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50';
                
                const stockStatus = getStockStatus(product.stock, product.min_stock);
                
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                    <i class="fas fa-box text-gray-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">${product.name}</div>
                                <div class="text-sm text-gray-500">${product.description || 'Sin descripción'}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            ${product.category}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${product.sku}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$${parseFloat(product.price).toFixed(2)}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${product.stock}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full ${stockStatus.class}">
                            ${stockStatus.text}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button onclick="editProduct(${product.id})" class="text-blue-600 hover:text-blue-900 mr-3">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="deleteProduct(${product.id})" class="text-red-600 hover:text-red-900">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                
                tbody.appendChild(row);
            });
        }

        function openProductModal(product = null) {
            editingProduct = product;
            const modal = document.getElementById('productModal');
            const title = document.getElementById('modalTitle');
            const form = document.getElementById('productForm');

            if (product) {
                title.textContent = 'Editar Producto';
                fillProductForm(product);
            } else {
                title.textContent = 'Nuevo Producto';
                form.reset();
            }

            modal.classList.remove('hidden');
        }

        function closeProductModal() {
            document.getElementById('productModal').classList.add('hidden');
            editingProduct = null;
        }

        function fillProductForm(product) {
            document.getElementById('productId').value = product.id;
            document.getElementById('productName').value = product.name;
            document.getElementById('productDescription').value = product.description || '';
            document.getElementById('productSku').value = product.sku;
            document.getElementById('productCategory').value = product.category;
            document.getElementById('productPrice').value = product.price;
            document.getElementById('productStock').value = product.stock;
            document.getElementById('productActive').checked = product.active == 1;
        }

        function saveProduct() {
            const formData = {
                name: document.getElementById('productName').value,
                description: document.getElementById('productDescription').value,
                sku: document.getElementById('productSku').value,
                category: document.getElementById('productCategory').value,
                price: document.getElementById('productPrice').value,
                stock: document.getElementById('productStock').value,
                active: document.getElementById('productActive').checked ? 1 : 0
            };

            const method = editingProduct ? 'put' : 'post';
            const url = editingProduct ? `${productsUrl}/${editingProduct.id}` : productsUrl;

            axios[method](url, formData)
                .then(response => {
                    showToast(editingProduct ? 'Producto actualizado' : 'Producto creado', 'success');
                    closeProductModal();
                    loadProducts();
                })
                .catch(error => {
                    console.error('Error guardando producto:', error);
                    showToast('Error guardando producto', 'error');
                });
        }

        function editProduct(id) {
            const product = products.find(p => p.id == id);
            if (product) {
                openProductModal(product);
            }
        }

        function deleteProduct(id) {
            if (confirm('¿Estás seguro de que quieres eliminar este producto?')) {
                axios.delete(`${productsUrl}/${id}`)
                    .then(response => {
                        showToast('Producto eliminado', 'success');
                        loadProducts();
                    })
                    .catch(error => {
                        console.error('Error eliminando producto:', error);
                        showToast('Error eliminando producto', 'error');
                    });
            }
        }

        function exportProducts() {
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