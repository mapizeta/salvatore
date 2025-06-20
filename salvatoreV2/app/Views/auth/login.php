<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Salvatore POS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>
<body class="bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md mx-4">
        <!-- Logo y título -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-store text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Salvatore POS</h1>
            <p class="text-gray-600">Sistema de Punto de Venta</p>
        </div>

        <!-- Formulario de login -->
        <form id="loginForm" class="space-y-6">
            <!-- Mensajes de error -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <!-- Usuario -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-user mr-2"></i>Usuario
                </label>
                <div class="relative">
                    <input type="text" 
                           id="username" 
                           name="username" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                           placeholder="Ingrese su usuario">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                </div>
            </div>

            <!-- Contraseña -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-lock mr-2"></i>Contraseña
                </label>
                <div class="relative">
                    <input type="password" 
                           id="password" 
                           name="password" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                           placeholder="Ingrese su contraseña">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                </div>
            </div>

            <!-- Botón de login -->
            <button type="submit" 
                    class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold py-3 px-4 rounded-lg hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 transform hover:scale-105">
                <i class="fas fa-sign-in-alt mr-2"></i>
                Iniciar Sesión
            </button>
        </form>

        <!-- Footer -->
        <div class="text-center mt-8 pt-6 border-t border-gray-200">
            <p class="text-sm text-gray-600">
                &copy; 2024 Salvatore POS. Todos los derechos reservados.
            </p>
        </div>
    </div>

    <script>
        // URLs del sistema
        const loginUrl = '<?= base_url('login') ?>';
        const dashboardUrl = '<?= base_url('dashboard') ?>';
        
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Mostrar loading
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Iniciando...';
            submitBtn.disabled = true;
            
            // Enviar formulario
            fetch(loginUrl, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(html => {
                // Si hay redirección, seguirla
                if (html.includes('dashboard')) {
                    window.location.href = dashboardUrl;
                } else {
                    // Mostrar error
                    Toastify({
                        text: "Error en las credenciales",
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#ef4444",
                        stopOnFocus: true
                    }).showToast();
                    
                    // Restaurar botón
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Toastify({
                    text: "Error de conexión",
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#ef4444",
                    stopOnFocus: true
                }).showToast();
                
                // Restaurar botón
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });

        // Animación de entrada
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.bg-white');
            form.style.opacity = '0';
            form.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                form.style.transition = 'all 0.5s ease';
                form.style.opacity = '1';
                form.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html> 