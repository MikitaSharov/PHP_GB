FROM php:8.2-fpm

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

RUN apt-get update && \
    apt-get install -y \
        zip \
        unzip \
        libmemcached-dev \
        libz-dev \
        zlib1g-dev \
        libssl-dev \
        pkg-config \
        autoconf \
        g++ \
        make && \
    pecl install memcached && \
    docker-php-ext-enable memcached && \
    docker-php-ext-install mysqli pdo pdo_mysql

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]
