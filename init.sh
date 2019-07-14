composer install
chown -R application:application *
php think init --db mysql://root:root@mysql:3306/sue_admin#utf8mb4 --redis @redis:6379
php think migrate:run
php think seed:run
