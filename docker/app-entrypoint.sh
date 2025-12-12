#!/bin/bash
set -e

echo "Installing PHP extensions..."
apt-get update
apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev libzip-dev unzip git

docker-php-ext-configure gd --with-freetype --with-jpeg
docker-php-ext-install pdo_mysql gd zip

echo "PHP extensions installed successfully!"

# Start PHP-FPM
php-fpm
