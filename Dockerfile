FROM php:5.6
RUN docker-php-ext-install pdo_mysql
RUN apt-get update && apt-get install -y git
COPY . /var/www/html/
RUN cp -rf /var/www/html/config/docker.php /var/www/html/config/base.php
CMD php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('SHA384', 'composer-setup.php') === '55d6ead61b29c7bdee5cccfb50076874187bd9f21f65d8991d46ec5cc90518f447387fb9f76ebae1fbbacf329e583e30') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && cd /var/www/html/ && php composer.phar install --no-dev \
    && php -S 0.0.0.0:8000 /var/www/html/public/index.php
