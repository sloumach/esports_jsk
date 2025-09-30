FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git curl unzip libpng-dev libonig-dev libxml2-dev zip \
    libsqlite3-dev pkg-config \
    && docker-php-ext-install pdo pdo_sqlite mbstring bcmath gd

COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

WORKDIR /var/www

# Copy sourcedo
COPY . .

# Install PHP & JS dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader \
    && npm install

EXPOSE 9000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=9000"]
