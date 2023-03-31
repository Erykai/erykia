#!/bin/bash
composer install --no-progress --no-interaction
exec apache2-foreground
cd /var/www/html/public/dashboard/assets
npm install
npm start
cd ../../../