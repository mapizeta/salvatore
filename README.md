# Salvatore - Sistema de Punto de Venta (POS)

## Descripción General

Salvatore es un sistema de punto de venta (POS) desarrollado en PHP que permite gestionar ventas, inventario, clientes, proveedores y reportes para pequeños y medianos negocios. El sistema incluye funcionalidades completas para el manejo de transacciones comerciales, control de stock, gestión de documentos fiscales e impresión de tickets térmicos.

### Características Principales

- **Gestión de Ventas**: Registro de ventas con múltiples métodos de pago
- **Control de Inventario**: Gestión de productos, categorías y stock
- **Gestión de Clientes**: Base de datos de clientes con información completa
- **Gestión de Proveedores**: Control de proveedores y compras
- **Documentos Fiscales**: Generación de facturas, boletas y guías de despacho
- **Reportes**: Reportes detallados de ventas, inventario y clientes
- **Impresión Térmica**: Soporte para impresoras térmicas de tickets
- **Multiidioma**: Soporte para español, inglés e indonesio
- **Códigos de Barras**: Escaneo y generación de códigos de barras

## Versiones de Tecnologías Utilizadas

### Framework Principal
- **CodeIgniter**: Versión 1.7.2 (Sistema principal)
- **CodeIgniter 4**: Versión 4.0+ (Proyecto SalvatoreV2 - en desarrollo)

### Tecnologías Frontend
- **jQuery**: Versión 1.2.6
- **jQuery UI**: Versión 1.5.3
- **CSS**: Estilos personalizados para interfaz de usuario

### Base de Datos
- **MySQL**: Motor de base de datos principal
- **Características**:
  - Charset: UTF-8
  - Collation: utf8_general_ci
  - Engine: InnoDB

### Servidor Web
- **PHP**: Compatible con PHP 4.3.2 o superior (CodeIgniter 1.7.2)
- **PHP 8.1+**: Requerido para SalvatoreV2 (CodeIgniter 4)

### Librerías y Dependencias
- **OFC Library**: Librería para gráficos y reportes
- **Faker**: Para generación de datos de prueba (SalvatoreV2)
- **PHPUnit**: Framework de testing (SalvatoreV2)

## Estructura del Proyecto

### Sistema Principal (CodeIgniter 1.7.2)
```
application/
├── config/          # Configuraciones del sistema
├── controllers/     # Controladores de la aplicación
├── models/          # Modelos de datos
├── views/           # Vistas y templates
├── language/        # Archivos de idioma
├── libraries/       # Librerías personalizadas
└── helpers/         # Helpers de utilidad

system/              # Core de CodeIgniter 1.7.2
```

### SalvatoreV2 (CodeIgniter 4)
```
salvatoreV2/
├── app/             # Código de la aplicación
├── public/          # Archivos públicos
├── writable/        # Archivos de escritura
└── tests/           # Tests unitarios
```

## Instalación y Configuración

### Requisitos del Sistema
- PHP 4.3.2+ (Sistema principal) / PHP 8.1+ (SalvatoreV2)
- MySQL 4.1+ / MySQL 5.0+
- Servidor web (Apache/Nginx)
- Extensión PHP MySQL
- Extensión PHP GD (para códigos de barras)

### Configuración de Base de Datos
1. Crear base de datos MySQL
2. Importar archivo SQL desde `database/`
3. Configurar conexión en `application/config/database.php`

### Configuración del Sistema
1. Configurar URL base en `application/config/config.php`
2. Ajustar configuraciones de empresa
3. Configurar impresora térmica (opcional)

## Módulos del Sistema

### 1. Ventas
- Registro de ventas
- Múltiples métodos de pago
- Gestión de carrito de compras
- Impresión de tickets
- Devoluciones

### 2. Inventario
- Gestión de productos
- Control de stock
- Categorías de productos
- Códigos de barras
- Alertas de stock mínimo

### 3. Clientes
- Base de datos de clientes
- Información de contacto
- Historial de compras
- Créditos y cuentas

### 4. Proveedores
- Gestión de proveedores
- Órdenes de compra
- Recepción de mercancía
- Documentos de compra

### 5. Reportes
- Reportes de ventas
- Reportes de inventario
- Reportes de clientes
- Gráficos y estadísticas

### 6. Configuración
- Configuración de empresa
- Gestión de usuarios
- Configuración de impresoras
- Backup de base de datos

## Características Técnicas

### Seguridad
- Autenticación de usuarios
- Control de acceso por módulos
- Validación de datos
- Protección contra SQL injection

### Rendimiento
- Caché de consultas
- Optimización de consultas
- Compresión de archivos
- Minificación de CSS/JS

### Compatibilidad
- Navegadores modernos
- Dispositivos móviles
- Impresoras térmicas
- Escáneres de códigos de barras

## Desarrollo y Mantenimiento

### Estructura de Código
- Patrón MVC (Model-View-Controller)
- Código modular y reutilizable
- Documentación en línea
- Estándares de codificación

### Testing
- Tests unitarios (SalvatoreV2)
- Tests de integración
- Validación de funcionalidades
- Control de calidad

### Actualizaciones
- Sistema de versionado
- Migraciones de base de datos
- Actualizaciones automáticas
- Backup antes de actualizaciones

## Licencia

Este proyecto utiliza las siguientes licencias:
- **CodeIgniter**: Licencia MIT
- **jQuery**: Licencia MIT/GPL
- **jQuery UI**: Licencia MIT/GPL
- **OFC Library**: Licencia GPL

## Soporte

Para soporte técnico y consultas:
- Documentación del sistema
- Guías de usuario
- Foro de desarrolladores
- Soporte por email

## Créditos

Desarrollado con las siguientes tecnologías:
- **CodeIgniter Framework** - EllisLab, Inc.
- **jQuery** - John Resig
- **jQuery UI** - Paul Bakaus
- **OFC Library** - Open Flash Chart

---

*Última actualización: Diciembre 2024*
