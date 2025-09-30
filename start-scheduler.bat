@echo off
echo Starting Laravel Scheduler...
echo This will run the dashboard sync every hour
echo Press Ctrl+C to stop
php artisan schedule:work

