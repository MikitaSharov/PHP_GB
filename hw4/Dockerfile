# Устанавливаем PHP 8.2
FROM php:8.2

# Указываем рабочую директорию
VOLUME /code

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Разрешаем использование Composer от имени суперпользователя
ENV COMPOSER_ALLOW_SUPERUSER 1

# Устанавливаем и настраиваем поддержку локали UTF-8
RUN apt-get update && \
    apt-get install -y locales && \
    echo "ru_RU.UTF-8 UTF-8" > /etc/locale.gen && \
    locale-gen ru_RU.UTF-8 && \
    update-locale LANG=ru_RU.UTF-8

# Устанавливаем переменные окружения для UTF-8
ENV LANG ru_RU.UTF-8
ENV LANGUAGE ru_RU:ru
ENV LC_ALL ru_RU.UTF-8

# Указываем рабочую директорию
WORKDIR /code