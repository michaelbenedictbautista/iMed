FROM php:8-apache
RUN apt update && \
apt install -y libzip-dev && \
apt install -y libfreetype6-dev && \
apt install -y libpng-dev && \
apt install -y libjpeg62-turbo-dev && \
docker-php-ext-install mysqli && docker-php-ext-enable mysqli && \
docker-php-ext-install zip && docker-php-ext-enable zip && \
docker-php-ext-configure gd --with-freetype --with-jpeg && \
docker-php-ext-install gd && docker-php-ext-enable gd && \
docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite && \
apt-get update && apt-get upgrade -y