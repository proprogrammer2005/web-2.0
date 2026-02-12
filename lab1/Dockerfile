FROM php:8.3-apache

RUN docker-php-ext-install pdo_mysql mysqli

RUN a2enmod rewrite

WORKDIR /var/www/html

COPY www/ /var/www/html/

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf