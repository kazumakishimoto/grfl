#!/bin/bash

set -eux

cd /var/www/grfl/src
php artisan migrate --force
php artisan config:cache
