#! /bin/bash

sudo chmod -R 777 /var/www/reporde
cd /var/www/reporde/
sudo composer install --no-ansi --no-dev --no-suggest --no-interaction --ignore-platform-reqs --no-progress --prefer-dist --no-scripts -d /var/www/reporde                                                                               
php artisan migrate
php artisan db:seed

