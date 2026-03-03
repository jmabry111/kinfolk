#!/bin/bash
set -e

echo "Running migrations..."
php artisan migrate --force

echo "Caching config, routes, views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Starting PHP-FPM..."
php-fpm -D

echo "Starting nginx..."
nginx -g 'daemon off;'
