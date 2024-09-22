FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  libmagickwand-dev --no-install-recommends \
  libpng-dev  \
  libzip-dev \
  libcurl4-openssl-dev \
  unzip \
  nano \
  curl \
  git \
  && rm -rf /var/lib/apt/lists/* \
  && a2enmod rewrite \
  && docker-php-ext-install exif \
  && docker-php-ext-configure gd --with-freetype --with-jpeg && docker-php-ext-install -j$(nproc) gd \
  && docker-php-ext-install mysqli pdo pdo_mysql intl opcache bcmath zip sockets curl pcntl

COPY ./docker/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY ./docker/uploads.ini /usr/local/etc/php/conf.d/uploads.ini

WORKDIR /var/www/html/

EXPOSE 80