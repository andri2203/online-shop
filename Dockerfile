# Base image PHP 8.3 dengan ekstensi yang dibutuhkan
FROM php:8.3-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev libpng-dev libonig-dev libxml2-dev \
    zip npm nodejs libpq-dev gnupg2 ca-certificates lsb-release \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js (v18 LTS, atau sesuai kebutuhan JS kamu)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Set working directory
WORKDIR /var/www

# Copy semua file
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install & Build frontend (JS/CSS)
RUN npm install && npm run build

# Permission
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

# Expose port Laravel
EXPOSE 8000

# Jalankan migrasi dan serve Laravel
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
