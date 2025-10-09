
# Dockerfile
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl unzip libpng-dev libonig-dev libxml2-dev zip \
    libsqlite3-dev pkg-config nodejs npm \
    && docker-php-ext-install pdo pdo_mysql mbstring bcmath gd

# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Install dependencies only once (vendor volume will persist)
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader

CMD ["php-fpm"]
