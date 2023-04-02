#!/bin/bash
composer install --no-progress --no-interaction &
apachectl -D FOREGROUND
tail -f /dev/null