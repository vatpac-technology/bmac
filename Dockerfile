#
# PHP Dependencies
#
FROM composer:2.4.2 as vendor

COPY database/ database/

COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

#
# Frontend
#
FROM node:14-alpine as frontend

RUN mkdir -p /app/public

COPY package.json package-lock.json webpack.mix.js /app/
COPY resources/ /app/resources/

WORKDIR /app
RUN npm ci && npm run prod

#
# Application
#
FROM php:8.1-fpm-alpine

RUN apk update && apk add --no-cache \
    supervisor \
    curl \
    openssl \
    nginx \
    libxml2-dev \
    oniguruma-dev \
    libzip-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    freetype-dev \
    pcre-dev $PHPIZE_DEPS \
    && rm -rf /var/cache/apk/*

RUN docker-php-ext-configure gd --with-jpeg --with-freetype
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl dom bcmath gd
RUN pecl install redis && docker-php-ext-enable redis.so

# Copy application files
WORKDIR /var/www/app
COPY --chown=www-data:www-data . /var/www/app
COPY --chown=www-data:www-data --from=vendor /app/vendor/ /var/www/app/vendor/
COPY --chown=www-data:www-data --from=frontend /app/public/js/ /var/www/app/public/js/
COPY --chown=www-data:www-data --from=frontend /app/public/css/ /var/www/app/public/css/
COPY --chown=www-data:www-data --from=frontend /app/mix-manifest.json /var/www/app/mix-manifest.json

# Copy docker files
RUN rm /usr/local/etc/php-fpm.d/zz-docker.conf
COPY docker_files/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker_files/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker_files/php.ini /etc/php8/conf.d/50-setting.ini
COPY docker_files/nginx.conf /etc/nginx/nginx.conf

# Add Cronjob if required
ADD docker_files/crontab.txt /crontab.txt
RUN /usr/bin/crontab /crontab.txt

EXPOSE 80
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]