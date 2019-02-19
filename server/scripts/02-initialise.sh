#!/usr/bin/env bash
composer install --dev
php artisan migrate
