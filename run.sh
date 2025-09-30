#!/bin/bash

echo "Starting POS Application..."
echo

echo "Checking if composer is installed..."
if ! command -v composer &> /dev/null; then
    echo "Composer is not installed. Please install Composer first."
    exit 1
fi

echo "Checking if PHP is installed..."
if ! command -v php &> /dev/null; then
    echo "PHP is not installed. Please install PHP first."
    exit 1
fi

echo "Installing dependencies..."
composer install

echo "Generating application key..."
php artisan key:generate

echo "Running migrations..."
php artisan migrate --seed

echo "Creating storage link..."
php artisan storage:link

echo
echo "Starting development server..."
echo "Application will be available at: http://localhost:8000"
echo
echo "Default login credentials:"
echo "Admin: admin@pos.com / password"
echo "Manager: manager@pos.com / password"
echo "Cashier: cashier@pos.com / password"
echo
echo "Press Ctrl+C to stop the server"
echo

php artisan serve






