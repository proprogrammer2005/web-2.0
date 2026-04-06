FROM php:8.3-apache

RUN docker-php-ext-install pdo_mysql mysqli

RUN a2enmod rewrite

WORKDIR /var/www/html

COPY www/ /var/www/html/

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

RUN set -eux; \
    { \
      echo '<Directory /var/www/html>'; \
      echo '    Require all granted'; \
      echo '    AllowOverride All'; \
      echo '    DirectoryIndex index.php index.html'; \
      echo '</Directory>'; \
    } > /etc/apache2/conf-available/lab3.conf; \
    a2enconf lab3

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
