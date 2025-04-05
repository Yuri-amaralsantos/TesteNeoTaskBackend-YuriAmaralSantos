FROM php:8.3-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libonig-dev libxml2-dev zip sqlite3 libsqlite3-dev npm

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy Laravel source
COPY . .

# Install PHP dependencies
RUN composer install

# Set permissions (optional: adjust for your setup)
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

# Laravel environment setup
RUN cp .env.example .env && \
    sed -i 's/DB_CONNECTION=.*/DB_CONNECTION=sqlite/' .env && \
    touch database/database.sqlite && \
    php artisan key:generate

CMD php artisan serve --host=0.0.0.0 --port=8000
