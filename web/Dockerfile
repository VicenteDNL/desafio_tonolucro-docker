FROM php:7.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
      unzip\
      curl


# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# RUN composer install

# Set working directory
WORKDIR /var/www/web
