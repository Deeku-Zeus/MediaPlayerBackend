#!/bin/sh

# Start the Laravel queue worker in the background
nohup php /var/www/html/artisan queue:work --sleep=3 --tries=3 > /var/www/html/storage/logs/queue_worker.log 2>&1 &

# Start the PHP built-in server in the foreground
php -S 0.0.0.0:80 -t public
