
FROM php:8.2-apache


RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    libpq-dev \
    npm

RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql


COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /var/www/html


RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf


WORKDIR /var/www/html


RUN composer install --no-dev --optimize-autoloader

RUN npm install && npm run build

RUN php artisan storage:link
RUN php artisan config:clear
RUN php artisan config:cache


RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache


COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 80


CMD ["/entrypoint.sh"]
