@echo off
echo Installing Laravel Scheduler as Windows Service...
echo This will create a Windows service to run the scheduler automatically

REM Create a simple service script
echo @echo off > scheduler-service.bat
echo cd /d "%~dp0" >> scheduler-service.bat
echo php artisan schedule:work >> scheduler-service.bat

echo.
echo To install as Windows service, you can use NSSM (Non-Sucking Service Manager):
echo 1. Download NSSM from https://nssm.cc/download
echo 2. Extract and run: nssm install LaravelScheduler
echo 3. Set Path to: %CD%\scheduler-service.bat
echo 4. Set Startup directory to: %CD%
echo 5. Start the service
echo.
echo Or run manually: start-scheduler.bat
pause

