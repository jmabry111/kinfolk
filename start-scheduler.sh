#!/bin/bash
set -e
echo "=== Kinfolk Scheduler ==="
sleep 5
echo "Running scheduler..."
php artisan schedule:run