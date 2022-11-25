# FROM nanoninja/php-fpm:8.1
FROM php:8.1-fpm

USER root

# Set working directory
WORKDIR /var/www

# Install dependencies
# RUN apt-get update && apt-get install -y software-properties-common 
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql
# RUN add-apt-repository ppa:ondrej/php
RUN  apt update && apt-get install -y \
    git \
    curl \
    zip \
    unzip
    
RUN docker-php-ext-install mysqli

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer self-update 2.3.10

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# RUN chown www-data:www-data /var/www/

# Change current user to www
# USER www-data

WORKDIR /var/www/html

RUN git config --global user.email "damian@test"
RUN git config --global user.name "damian"
