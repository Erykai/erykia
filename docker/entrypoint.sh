#!/bin/bash
composer install --no-progress --no-interaction &
apachectl -D FOREGROUND &
cd public/dashboard/assets && npm install && npm start
tail -f /dev/null