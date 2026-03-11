#!/bin/bash
set -e

if [ "$SERVICE_TYPE" = "scheduler" ]; then
  echo "=== Kinfolk Scheduler ==="
  sleep 5
  php artisan schedule:run
  exit 0
fi

echo "=== Kinfolk Startup ==="
chmod -R 775 /app/storage /app/bootstrap/cache
echo "Running migrations..."
php artisan migrate --force

echo "Caching..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Starting server on port $PORT..."
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
