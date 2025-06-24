FROM php:5.6-apache

RUN docker-php-ext-install mysqli

# Habilitar mod_rewrite (CodeIgniter lo necesita si usas URLs amigables)
RUN a2enmod rewrite

# Configurar Apache para CodeIgniter
RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Configurar el DocumentRoot para que apunte al directorio correcto
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html|' /etc/apache2/sites-available/000-default.conf

# Crear usuario con el mismo UID que el usuario host
ARG USER_ID=1000
ARG GROUP_ID=1000
RUN groupadd -g $GROUP_ID appuser && \
    useradd -u $USER_ID -g appuser -s /bin/bash -m appuser

# Cambiar el usuario de Apache a appuser
RUN sed -i 's/export APACHE_RUN_USER=www-data/export APACHE_RUN_USER=appuser/' /etc/apache2/envvars && \
    sed -i 's/export APACHE_RUN_GROUP=www-data/export APACHE_RUN_GROUP=appuser/' /etc/apache2/envvars

# Exponer el puerto 80
EXPOSE 80

# Comando por defecto
CMD ["apache2-foreground"]
