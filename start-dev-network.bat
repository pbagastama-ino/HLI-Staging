@echo off
echo Starting Laravel development server for network access...
echo Your project will be accessible at: http://192.168.21.24:8000
echo Vite dev server will be accessible at: http://192.168.21.24:5173
echo.
echo Press Ctrl+C to stop the servers
echo.

REM Start Laravel server on all interfaces
php artisan serve --host=0.0.0.0 --port=8000

pause

