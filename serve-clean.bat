@echo off
cd /d %~dp0
start "artisan-serve" /min cmd /c "D:\laragon\bin\php\php-8.3.32-Win32-vs16-x64\php.exe artisan serve --port=8000 < NUL > serve.log 2>&1"
