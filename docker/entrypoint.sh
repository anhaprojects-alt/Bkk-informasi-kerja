#!/bin/sh
set -eu

# Railway provides PORT at runtime. Generate the nginx config without storing
# secrets in the image or committing environment-specific configuration.
: "${PORT:=8080}"
envsubst '${PORT}' < /etc/nginx/templates/nginx.conf.template > /etc/nginx/nginx.conf

# Laravel requires an application key and writable runtime directories.
if [ -z "${APP_KEY:-}" ]; then
    echo "APP_KEY is required in the Railway environment" >&2
    exit 1
fi

mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Run migrations only at runtime, never while building the image.
php artisan migrate --force
php artisan storage:link --force >/dev/null 2>&1 || true
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec "$@"
