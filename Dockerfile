FROM php:8.0-apache
WORKDIR /var/www/html
COPY src/public/index.php .
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN apt-get update && \
    apt-get install -y libxml2-dev
RUN docker-php-ext-install soap && docker-php-ext-enable soap
RUN a2enmod rewrite
RUN apt-get -y update && apt-get -y upgrade

EXPOSE 80