FROM node:24.10 AS buildpublic
WORKDIR /usr/local/src/bmac


# Build public elements.
COPY webpack.mix.js .
COPY resources/ resources/
COPY public/ public/
COPY *.json .
COPY artisan .

RUN npm i --omit dev 
RUN npm i laravel-mix
RUN npx mix --production

RUN rm -rf node_modules/

FROM dunglas/frankenphp:1.9.1-php8.2 AS run

# Required extensions for app and composer.
RUN apt update && apt install git zip -y
RUN install-php-extensions mysqli pdo pdo_mysql

WORKDIR /app
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY . .
COPY --from=buildpublic /usr/local/src/bmac/public /app/public/

# Setup php server
COPY ./Caddyfile /etc/frankenphp/Caddyfile
RUN cp $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini

RUN composer install --no-dev -o --ignore-platform-reqs

RUN php artisan storage:link

WORKDIR /app/public

EXPOSE 80