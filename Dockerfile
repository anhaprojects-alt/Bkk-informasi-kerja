# Stage 1: Build frontend assets
FROM node:20-alpine AS asset-builder
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# Stage 2: Production PHP + Nginx runtime for Railway
FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    nginx \
    supervisor \
    gettext \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    webp-dev \
    freetype-dev \
    libxml2-dev \
    postgresql-dev \
    zip \
    unzip \
    git

RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql bcmath gd

RUN printf "upload_max_filesize=32M\npost_max_size=64M\nmemory_limit=256M\n" > /usr/local/etc/php/conf.d/uploads.ini

WORKDIR /var/www/html

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-progress --prefer-dist --optimize-autoloader --no-scripts

COPY . .
COPY --from=asset-builder /app/public/build ./public/build

RUN composer run-script post-autoload-dump

COPY docker/nginx.conf /etc/nginx/templates/nginx.conf.template
COPY docker/entrypoint.sh /usr/local/bin/railway-entrypoint
COPY docker/supervisord.conf /etc/supervisord.conf
RUN chmod +x /usr/local/bin/railway-entrypoint \
    && mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache \
    && mkdir -p storage/app/public/profiles/avatars storage/app/public/profiles/banners \
    && chown -R www-data:www-data storage bootstrap/cache \
    && rm -f /etc/nginx/http.d/default.conf

ENV APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stderr \
    PORT=8080

EXPOSE 8080

ENTRYPOINT ["/usr/local/bin/railway-entrypoint"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
