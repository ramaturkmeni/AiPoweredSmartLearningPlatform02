@echo off
chcp 65001 >nul
title Smart Learn - Cache Cleaner

echo ============================================
echo    Smart Learn - Cache Cleaner
echo ============================================
echo.

echo [1/4] Clearing route cache...
php artisan route:clear
echo.

echo [2/4] Clearing config cache...
php artisan config:clear
echo.

echo [3/4] Clearing application cache...
php artisan cache:clear
echo.

echo [4/4] Clearing view cache...
php artisan view:clear
echo.

echo ============================================
echo    Done! All caches cleared successfully.
echo ============================================
echo.

pause
