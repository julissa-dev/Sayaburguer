# Usa PHP con Apache (versión 8.2)
FROM php:8.2-apache

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia todo tu proyecto al contenedor
COPY . /var/www/html

# Establece directorio de trabajo
WORKDIR /var/www/html

# Instala dependencias PHP (Laravel)
RUN composer install --no-dev --optimize-autoloader

# Da permisos a storage y cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expone el puerto 80 (Apache)
EXPOSE 80

# Comando de inicio: migra y levanta Apache
CMD php artisan migrate --force && apache2-foreground
