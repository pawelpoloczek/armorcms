#!/usr/bin/env bash

apt-get -qy update \
    && mkdir -p /usr/share/man/man1 \
    && mkdir -p /usr/share/man/man7 \
    && apt-get install -qy util-linux nano wget unzip libzip-dev locales libicu-dev zlib1g-dev libghc-postgresql-libpq-dev git libcurl4-openssl-dev vim postgresql libpng-dev libjpeg-dev libldap2-dev librabbitmq-dev curl \
    && locale-gen C.UTF-8 \
    && /usr/sbin/update-locale LANG=C.UTF-8 \
    && apt-get autoremove -y \
    && apt-get clean all

pecl config-set php_ini /usr/local/etc/php/php.ini
pecl install apcu redis-5.3.7 amqp-1.11.0 xdebug
docker-php-ext-configure pgsql --with-pgsql=/usr/include/postgresql/
docker-php-ext-configure gd --with-jpeg-dir=/usr/include/
docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/
docker-php-ext-configure pcntl --enable-pcntl
docker-php-ext-install -j$(nproc) pdo pgsql pdo_pgsql pdo_mysql mysqli intl opcache bcmath zip gd sockets curl ldap pcntl
docker-php-ext-enable curl gd apcu redis amqp xdebug

touch /tmp/xdebug.log
chmod 777 /tmp/xdebug.log
