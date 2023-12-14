#!/bin/bash
composer install && chmod -R 777 /var/www/html/var && chmod -R 777 /var/www/html/public/photos && php bin/console doctrine:mongodb:schema:create
apache2-foreground

