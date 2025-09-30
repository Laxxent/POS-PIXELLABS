@echo off
echo Starting POS Application...
echo.

echo Checking if composer is installed...
composer --version >nul 2>&1
if %errorlevel% neq 0 (
    echo Composer is not installed. Please install Composer first.
    pause
    exit /b 1
)

echo Checking if PHP is installed...
php --version >nul 2>&1
if %errorlevel% neq 0 (
    echo PHP is not installed. Please install PHP first.
    pause
    exit /b 1
)

echo Installing dependencies...
composer install

echo Generating application key...
php artisan key:generate

echo Running migrations...
php artisan migrate --seed

echo Creating storage link...
php artisan storage:link

echo.
echo Starting development server...
echo Application will be available at: http://localhost:8000
echo.
echo Default login credentials:
echo Admin: admin@pos.com / password
echo Manager: manager@pos.com / password
echo Cashier: cashier@pos.com / password
echo.
echo Press Ctrl+C to stop the server
echo.

php artisan serve






