FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql \
    && a2enmod rewrite \
    && echo "DirectoryIndex Index.php index.php index.html" > /etc/apache2/conf-available/zz-dirindex.conf \
    && a2enconf zz-dirindex

COPY PemesananLapanganFutsal/ /var/www/html/
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html
