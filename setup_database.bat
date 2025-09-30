@echo off
echo Setting up POS Application Database...
echo.

echo Step 1: Creating database...
mysql -u root -e "CREATE DATABASE IF NOT EXISTS pos_application CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

if %errorlevel% neq 0 (
    echo Error creating database. Please check your MySQL connection.
    echo Make sure MySQL is running and root password is correct.
    pause
    exit /b 1
)

echo Database created successfully!
echo.

echo Step 2: Running migrations...
php artisan migrate:fresh --seed

if %errorlevel% neq 0 (
    echo Error running migrations. Please check your database configuration.
    pause
    exit /b 1
)

echo.
echo Database setup completed successfully!
echo.
echo You can now run: php artisan serve
echo.
pause





