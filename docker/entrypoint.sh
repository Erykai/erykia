#!/bin/bash
composer install --no-progress --no-interaction
exec apache2-foreground