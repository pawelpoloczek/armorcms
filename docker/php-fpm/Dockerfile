FROM composer:2.6 AS composer
FROM php:8.2-fpm-bullseye

WORKDIR /var/www/armorcms

COPY --from=composer /usr/bin/composer /usr/local/bin/composer
COPY ./docker/php-fpm/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY ["./docker/php-fpm/php-configure.sh", "/opt/bin/"]

RUN /bin/bash /opt/bin/php-configure.sh

RUN rm -rf /var/www/html/ \
    && chown test -R www-data:www-data /var/www/

#USER www-data
#RUN usermod --non-unique --uid 1000 www-data

RUN mkdir /var/www/.composer && chmod -R 777 /var/www/.composer

EXPOSE 9000