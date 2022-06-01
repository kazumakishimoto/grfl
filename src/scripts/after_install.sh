#!/bin/bash

set -eux

cd ~/src
php artisan migrate --force
php artisan config:cache
