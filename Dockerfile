# CodeIgniter 3.1.6 is not compatible with PHP 8, so pin PHP 7.4
FROM php:7.4-apache

RUN docker-php-ext-install mysqli pdo_mysql \
    && a2enmod rewrite

# Serve index.php/mod_rewrite from .htaccess
RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

RUN echo "session.save_path=/tmp" > /usr/local/etc/php/conf.d/session.ini

WORKDIR /var/www/html
COPY . /var/www/html

RUN mkdir -p uploads/work_orders application/cache application/logs \
    && chown -R www-data:www-data uploads application/cache application/logs assets/images
