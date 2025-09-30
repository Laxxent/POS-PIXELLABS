@echo off
echo Starting POS Application...
echo.

echo Checking if server is already running...
netstat -an | find "127.0.0.1:8000" >nul
if %errorlevel% equ 0 (
    echo Server is already running at http://localhost:8000
    echo.
    echo Opening browser...
    start http://localhost:8000
    pause
    exit /b 0
)

echo Starting Laravel development server...
echo.
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





