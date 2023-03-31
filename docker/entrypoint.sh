#!/bin/bash
composer install --no-progress --no-interaction
cd /var/www/html/public/dashboard/assets
npm install
npm start
cd ../../../
exec apache2-foreground