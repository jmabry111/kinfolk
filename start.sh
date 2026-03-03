#!/bin/bash
set -e

echo "=== Kinfolk Startup ==="

echo "Storage permissions..."
chmod -R 775 /app/storage /app/bootstrap/cache

echo "Running migrations..."
php artisan migrate --force

echo "Caching..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Starting server on port $PORT..."
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
