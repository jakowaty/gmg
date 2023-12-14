#!/bin/bash
composer install && php bin/console doctrine:mongodb:schema:create && chmod -R 777 /var/www/html/var && chmod -R 777 /var/www/html/public/photos
apache2-foreground

