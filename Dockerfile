# Stage 1: Build Frontend Assets with Node
FROM node:20-alpine AS asset-builder
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# Stage 2: Production PHP Environment
FROM php:8.3-fpm-alpine

# Install system dependencies and PHP extensions
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    libpng-dev \
    libxml2-dev \
    postgresql-dev \
    zip \
    unzip \
    git

RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql bcmath gd

# Configure Nginx
COPY docker/nginx.conf /etc/nginx/nginx.conf

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .
COPY --from=asset-builder /app/public/build ./public/build

# Install Composer production dependencies
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Set directory permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port
EXPOSE 80

# Start Supervisor to run both Nginx & PHP-FPM
CMD ["/usr/bin/supervisord", "-c", "/var/www/html/docker/supervisord.conf"]
