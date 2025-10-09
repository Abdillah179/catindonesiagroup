FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev \
    zip unzip libzip-dev libpq-dev

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip

# Get Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --optimize-autoloader --no-dev

RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8080

CMD php artisan config:cache && \
    php artisan route:cache && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=8080