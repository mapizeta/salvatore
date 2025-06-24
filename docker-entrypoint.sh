#!/bin/bash

# Configurar permisos para el directorio web
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html

# Asegurar que el directorio de logs tenga permisos correctos
mkdir -p /var/www/html/application/logs
chown -R www-data:www-data /var/www/html/application/logs
chmod -R 777 /var/www/html/application/logs

# Asegurar que el directorio de caché tenga permisos correctos
mkdir -p /var/www/html/application/cache
chown -R www-data:www-data /var/www/html/application/cache
chmod -R 777 /var/www/html/application/cache

# Iniciar Apache en primer plano
exec apache2-foreground 