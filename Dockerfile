# Dockerfile
FROM php:8.1-apache

# Instalar dependencias necesarias
RUN apt-get update && \
    apt-get install -y libzip-dev unzip && \
    docker-php-ext-install pdo pdo_mysql zip && \
    apt-get install -y nodejs npm

# Habilitar mod_rewrite para Laravel
RUN a2enmod rewrite

# Configurar Apache
COPY ./apache.conf /etc/apache2/sites-available/000-default.conf

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Copiar el código de Laravel al contenedor
COPY . /var/www/html

# Permisos
RUN mkdir -p /var/www/html/storage && \
    chown -R www-data:www-data /var/www/html && \
    chmod 777 -R /var/www/html/storage/

# Exponer el puerto 80 para Apache
EXPOSE 80
