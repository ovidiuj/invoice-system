#!/bin/bash

echo "xdebug.remote_host=${DOCKER_IP}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
echo "xdebug.remote_port=${XDEBUG_PORT}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
cp "/var/www/docker/php/config/${SYMFONY_ENV}/custom.ini" /usr/local/etc/php/conf.d/custom.ini

service memcached start

cd /var/www

if [[ ! -e /.firstrun ]]; then
    chown -R www-data: /var/www

    echo '-- COMPOSER INSTALL --'
    su -c www-data -c 'composer install --optimize-autoloader'
    su -c www-data -c 'composer dump-autoload'

    echo '-- CLEAR CACHE --'
    php bin/console cache:clear --env=$SYMFONY_ENV --no-debug --no-warmup
    php bin/console doctrine:migrations:migrate

    now=$(date)
    echo "First run: $now"  >> /.firstrun
fi

chmod -R 777 /var/www/var/cache
chmod -R 777 /var/www/var/logs
chown root:staff /usr/local/etc/php/conf.d/custom.ini

#php bin/console assetic:watch &

echo '-- RUN FPM --'

yarn encore dev

php-fpm