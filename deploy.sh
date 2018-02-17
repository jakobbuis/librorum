#!/bin/bash
set -euo pipefail

# Function that runs on the server
function deploy {
    cd /opt/librorum

    php artisan down
    php artisan clear-compiled
    php artisan cache:clear
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear

    git pull

    composer install --no-interaction --no-dev --prefer-dist --optimize-autoloader

    npm install
    npm run prod

    php artisan up

    exit
}

ssh jakob@librorum.jakobbuis.nl "$(typeset -f); deploy"
