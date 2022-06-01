#!/bin/bash

set -eux

cd ~/grfl
php artisan migrate --force
php artisan config:cache
