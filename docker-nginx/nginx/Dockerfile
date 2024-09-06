FROM nginx:1.27-alpine

RUN apk --no-cache add shadow nano \
    && adduser -S www-data -u 1000 \
    && usermod -s /bin/bash www-data

COPY ./docker-nginx/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./docker-nginx/nginx/upstream.conf /etc/nginx/upstream.conf
COPY ./docker-nginx/nginx/server.conf /etc/nginx/server.conf
COPY ./docker-nginx/nginx/default.conf /etc/nginx/conf.d/default.conf

COPY ./public/ /var/www/armorcms/public