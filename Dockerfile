FROM alpine:3.15

WORKDIR /application

# Essentials
ENV TZ=Australia/Sydney
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN apk add --no-cache zip unzip curl sqlite nginx supervisor nano

# Installing PHP
RUN apk add --no-cache php8 \
    php8-common \
    php8-fpm \
    php8-pdo \
    php8-opcache \
    php8-zip \
    php8-phar \
    php8-iconv \
    php8-cli \
    php8-curl \
    php8-openssl \
    php8-mbstring \
    php8-tokenizer \
    php8-fileinfo \
    php8-json \
    php8-xml \
    php8-xmlwriter \
    php8-simplexml \
    php8-dom \
    php8-pdo_mysql \
    php8-pdo_sqlite \
    php8-tokenizer \
    php8-pecl-redis \
    php8-gd \
    php8-exif \
    php8-pcntl \
    php8-xmlreader \ 
    php8-posix

RUN ln -s /usr/bin/php8 /usr/bin/php

RUN rm -rf /var/cache/apk/* /etc/php8/php-fpm.d/www.conf

# Installing composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN rm -rf composer-setup.php

# Copy application and docker_files
COPY . /application
COPY docker_files/php.ini /etc/php8/conf.d/50-setting.ini
COPY docker_files/php-fpm.conf /etc/php8/php-fpm.conf
COPY docker_files/nginx.conf /etc/nginx/nginx.conf
COPY docker_files/start_nginx.sh /application/start_nginx.sh
COPY docker_files/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Add Cronjob if required
#ADD docker_files/crontab.txt /crontab.txt
#RUN /usr/bin/crontab /crontab.txt

# Building process
RUN cd /application && composer install --optimize-autoloader --no-dev && chown -R nobody:nobody /application && chmod +x /application/start_nginx.sh

EXPOSE 80

# Configure Loging output to docker logs
#RUN ln -sf /dev/stdout /application/storage/logs/laravel.log
RUN ln -sf /dev/stdout /var/log/nginx/access.log
RUN ln -sf /dev/stderr /var/log/nginx/error.log

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
