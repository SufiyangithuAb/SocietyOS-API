FROM php:8.2-apache

RUN docker-php-ext-install pdo_mysql

CMD ["apache2ctl", "-M"]
