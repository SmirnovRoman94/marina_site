# Install Laravel packages
composer install

if [ ! -e ./.env ]; then
  cp .env.example .env
fi

sleep 60 # ждем завершения инициализации db
php artisan migrate
php artisan key:generate
php artisan regBot
php artisan telegraph:set-webhook
php artisan serve --host=0.0.0.0
