#!/bin/bash
set -e

if [ "$SERVICE_TYPE" = "scheduler" ]; then
  echo "=== Kinfolk Scheduler ==="
  sleep 5
  php artisan schedule:run
  exit 0
fi

echo "=== Kinfolk Startup ==="
echo "Waiting for database..."
until php -r "new PDO('mysql:host=mysql;port=3306;dbname=railway', 'root', '${DB_PASSWORD}');" 2>/dev/null; do

  echo "DB not ready, retrying in 3s..."
  sleep 3
done
chmod -R 775 /app/storage /app/bootstrap/cache
echo "Running migrations..."
php artisan migrate --force

echo "Caching..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Starting server on port $PORT..."
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
