#!/bin/bash
echo "Running in $APP_ENV"

echo "Performing php artisan migrate --force --seed"
php artisan migrate --force --seed

echo "Clear application cache"
php artisan cache:clear
