composer install
php artisan migrate
docker-compose up -d
exit
composer install
php artisan db:seed
exit
