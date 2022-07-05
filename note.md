#run migration
php artisan migrate:refresh
php artisan passport:install
php artisan passport:keys --force
