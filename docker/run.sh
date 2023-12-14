#!/bin/bash
mkdir -p /var/www/html/public/photos
chmod -R 777 /var/www/html/public/photos
composer install
apache2-foreground

