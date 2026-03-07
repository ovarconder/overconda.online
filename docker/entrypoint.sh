#!/bin/bash
set -e
if [ ! -d /var/www/html/vendor ]; then
    echo "Running composer install..."
    cd /var/www/html && composer install --no-dev --no-interaction
fi
exec apache2-foreground
