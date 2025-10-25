# Gunakan image PHP base (Alpine adalah yang paling ringan)
FROM php:8.2-fpm-alpine

# Set working directory di dalam container
WORKDIR /var/www/html

# Instal dependensi sistem dan ekstensi PHP yang diperlukan
RUN apk add --no-cache \
    $PHPIZE_DEPS \
    autoconf \
    build-base \
    git \
    oniguruma-dev \
    libzip-dev \
    mysql-client \
    && docker-php-ext-install pdo_mysql zip opcache 

# Instal Composer (Dependency Manager PHP)
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Salin SEMUA file project ke working directory
# Termasuk composer.json, composer.lock, dan semua kode
COPY . . 

# Instal dependensi Composer (akan dieksekusi di dalam container)
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Konfigurasi perizinan (permission) untuk folder storage
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Expose port (biasanya diakses via nginx/apache, tapi baik untuk didefinisikan)
EXPOSE 9000

# Perintah default untuk menjalankan PHP-FPM
CMD ["php-fpm"]
