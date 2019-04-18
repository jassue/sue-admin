composer install
chown -R application:application *
php think migrate:run
php think seed:run
