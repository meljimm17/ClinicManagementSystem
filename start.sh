#!/bin/bash
php artisan config:cache
php artisan migrate --force
php artisan db:seed --force
apache2-foreground