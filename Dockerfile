FROM php:5.6
RUN docker-php-ext-install pdo_mysql
COPY . /var/www/html/
RUN cp -rf /var/www/html/config/docker.php /var/www/html/config/base.php
CMD php -S 0.0.0.0:8000 /var/www/html/public/index.php
