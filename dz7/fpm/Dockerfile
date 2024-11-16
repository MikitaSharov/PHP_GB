FROM php:8.2-fpm

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

RUN apt-get update && apt-get install -y \
    zip unzip \
    libxml2-dev \
    autoconf \
    gcc \
    make \
    --no-install-recommends

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN pecl install xdebug-3.2.0 && docker-php-ext-enable xdebug

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]
