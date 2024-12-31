ARG PHP_VERSION=8.0

FROM serversideup/php:${PHP_VERSION}-fpm-nginx
ENV NGINX_WEBROOT=/var/www/html/web

COPY --chown=www-data:www-data composer.json .
RUN composer install && mkdir boxes

COPY --chown=www-data:www-data composer.json src web .

VOLUME /var/www/html/boxes
