FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git curl unzip libpng-dev libonig-dev libxml2-dev zip \
<<<<<<< HEAD
    libsqlite3-dev pkg-config libzip-dev \
    default-mysql-client libfreetype6-dev libjpeg62-turbo-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite mbstring bcmath gd zip
=======
    libsqlite3-dev pkg-config \
    && docker-php-ext-install pdo pdo_sqlite mbstring bcmath gd
>>>>>>> 49f5d6c060f13982c08d9fbd532f37bdbce8b3ab

COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

WORKDIR /var/www

<<<<<<< HEAD
COPY . .

=======
# Copy sourcedo
COPY . .

# Install PHP & JS dependencies
>>>>>>> 49f5d6c060f13982c08d9fbd532f37bdbce8b3ab
RUN composer install --no-interaction --prefer-dist --optimize-autoloader \
    && npm install

EXPOSE 9000

<<<<<<< HEAD
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=9000"]
=======
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=9000"]
>>>>>>> 49f5d6c060f13982c08d9fbd532f37bdbce8b3ab
