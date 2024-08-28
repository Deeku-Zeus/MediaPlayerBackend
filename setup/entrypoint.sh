#!/bin/sh

# Navigate to the working directory
# shellcheck disable=SC2164
cd /var/www/html

# Install Composer dependencies
composer install --no-interaction --prefer-dist --optimize-autoloader

# Update Composer dependencies (if needed)
composer update --no-interaction --prefer-dist --optimize-autoloader

# Run database migrations
php artisan migrate --force

# Create storage symlink
php artisan storage:link

# Run the queue worker in the background
php /var/www/html/artisan queue:work --sleep=3 --tries=3 &

#tmux new-session -d -s queue_worker "php /var/www/html/artisan queue:work --sleep=3 --tries=3"

# Start the PHP built-in server in the foreground
php -S 0.0.0.0:80 -t public
