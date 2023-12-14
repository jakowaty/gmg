#!/bin/bash
php composer install && chmod -R 777 /var/www/html/var && mkdir /var/www/html/public/photos && chmod -R 777 /var/www/html/public/photos
apache2-foreground

