# Salvatore POS V2 - Sistema de Punto de Venta Moderno

Sistema de punto de venta moderno construido con CodeIgniter 4, PHP 8.2+, MySQL 8.0+ y tecnologías frontend modernas.

## 🚀 Características

- **Frontend Moderno**: Vue.js 3, Tailwind CSS, Axios, Toastify
- **Backend Robusto**: CodeIgniter 4, PHP 8.2+
- **Base de Datos**: MySQL 8.0+ con migraciones y seeders
- **Autenticación**: Sistema de login seguro con sesiones
- **Dashboard Interactivo**: Gráficos en tiempo real con Chart.js
- **API RESTful**: Endpoints JSON para integración
- **Responsive Design**: Interfaz adaptativa para móviles y desktop
- **Gestión Completa**: Productos, clientes, ventas, reportes

## 📋 Requisitos del Sistema

- **PHP**: 8.2 o superior
- **MySQL**: 8.0 o superior
- **Composer**: Última versión
- **Node.js**: 16+ (opcional, para desarrollo)
- **Servidor Web**: Apache/Nginx

## 🛠️ Instalación

### 1. Clonar el Proyecto

```bash
git clone <repository-url>
cd salvatoreV2
```

### 2. Instalar Dependencias

```bash
composer install
```

### 3. Configurar Base de Datos

1. Crear una base de datos MySQL llamada `salvatore_v2`
2. Copiar el archivo de configuración:

```bash
cp env.example .env
```

3. Editar `.env` y configurar la base de datos:

```env
database.default.hostname = localhost
database.default.database = salvatore_v2
database.default.username = tu_usuario
database.default.password = tu_contraseña
database.default.DBDriver = MySQLi
database.default.port = 3306
```

### 4. Ejecutar Migraciones

```bash
php spark migrate
```

### 5. Ejecutar Seeders (Datos Iniciales)

```bash
php spark db:seed InitialData
```

### 6. Configurar Permisos

```bash
chmod -R 755 writable/
```

### 7. Iniciar el Servidor

```bash
php spark serve
```

El sistema estará disponible en: `http://localhost:8080`

## 🔐 Credenciales por Defecto

- **Usuario**: `admin`
- **Contraseña**: `admin123`

## 📁 Estructura del Proyecto

```
salvatoreV2/
├── app/
│   ├── Config/           # Configuraciones
│   ├── Controllers/      # Controladores
│   ├── Models/          # Modelos de datos
│   ├── Views/           # Vistas
│   ├── Filters/         # Filtros
│   └── Database/        # Migraciones y Seeders
├── public/              # Archivos públicos
├── writable/            # Archivos de escritura
└── vendor/              # Dependencias de Composer
```

## 🎯 Funcionalidades Principales

### Dashboard
- Estadísticas en tiempo real
- Gráficos de ventas semanales
- Productos más vendidos
- Actividad reciente

### Gestión de Productos
- CRUD completo de productos
- Control de inventario
- Códigos de barras y SKU
- Categorización

### Gestión de Clientes
- Registro de clientes
- Historial de compras
- Información de contacto
- Límites de crédito

### Ventas
- Registro de ventas
- Múltiples métodos de pago
- Descuentos y impuestos
- Tickets de venta

### Reportes
- Reportes de ventas
- Análisis de productos
- Estadísticas de clientes
- Exportación de datos

## 🔧 Configuración Avanzada

### Configurar Apache (Virtual Host)

```apache
<VirtualHost *:80>
    ServerName salvatore.local
    DocumentRoot /path/to/salvatoreV2/public
    
    <Directory /path/to/salvatoreV2/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### Configurar Nginx

```nginx
server {
    listen 80;
    server_name salvatore.local;
    root /path/to/salvatoreV2/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## 🚀 Comandos Útiles

```bash
# Ejecutar migraciones
php spark migrate

# Revertir migraciones
php spark migrate:rollback

# Ejecutar seeders
php spark db:seed InitialData

# Limpiar cache
php spark cache:clear

# Verificar rutas
php spark routes

# Iniciar servidor de desarrollo
php spark serve

# Ejecutar tests
php spark test
```

## 📊 API Endpoints

### Autenticación
- `GET /auth/check` - Verificar autenticación
- `POST /login` - Iniciar sesión
- `GET /logout` - Cerrar sesión

### Dashboard
- `GET /api/dashboard/stats` - Estadísticas del dashboard

### Productos
- `GET /products/api` - Listar productos
- `POST /products/api` - Crear producto
- `PUT /products/api/{id}` - Actualizar producto
- `DELETE /products/api/{id}` - Eliminar producto

### Clientes
- `GET /customers/api` - Listar clientes
- `POST /customers/api` - Crear cliente
- `PUT /customers/api/{id}` - Actualizar cliente
- `DELETE /customers/api/{id}` - Eliminar cliente

### Ventas
- `GET /sales/api` - Listar ventas
- `POST /sales/api` - Crear venta
- `GET /sales/api/{id}` - Obtener venta
- `PUT /sales/api/{id}` - Actualizar venta
- `DELETE /sales/api/{id}` - Eliminar venta

## 🛡️ Seguridad

- Autenticación basada en sesiones
- Validación de datos en servidor
- Protección CSRF
- Filtros de entrada
- Contraseñas hasheadas
- Control de acceso por roles

## 🔄 Migración desde Salvatore Original

Para migrar datos desde el sistema original:

1. Exportar datos de la base de datos original
2. Crear script de migración personalizado
3. Ejecutar migración de datos
4. Verificar integridad de datos

## 🐛 Solución de Problemas

### Error de Permisos
```bash
chmod -R 755 writable/
chown -R www-data:www-data writable/
```

### Error de Base de Datos
- Verificar configuración en `.env`
- Asegurar que MySQL esté ejecutándose
- Verificar credenciales de acceso

### Error de Composer
```bash
composer dump-autoload
composer clear-cache
```

## 📝 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## 🤝 Contribución

1. Fork el proyecto
2. Crear una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abrir un Pull Request

## 📞 Soporte

Para soporte técnico o consultas:
- Email: soporte@salvatore.com
- Documentación: [Wiki del Proyecto]
- Issues: [GitHub Issues]

---

**Desarrollado con ❤️ para modernizar el sistema Salvatore POS**
