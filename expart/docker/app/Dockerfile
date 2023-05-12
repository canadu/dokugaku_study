FROM php:8-apache
# viをインストール
RUN apt-get update && apt-get -y install vim \
    && a2enmod rewrite

WORKDIR /var/www/html

# PHP で必要なライブラリをインストール
RUN apt-get update \
    && apt-get install -y libonig-dev libzip-dev unzip mariadb-client git \
    && docker-php-ext-install pdo_mysql mysqli mbstring zip \
    && git clone https://github.com/xdebug/xdebug.git \
    && cd xdebug \
    && phpize \
    && ./configure \
    && make \
    && make install \
    && docker-php-ext-enable xdebug

# PHP で必要なライブラリをインストール
# RUN apt-get update \
#     && apt-get install -y libonig-dev libzip-dev unzip mariadb-client \
#     && docker-php-ext-install pdo_mysql mysqli mbstring zip \
#     && pecl install xdebug \
#     && docker-php-ext-enable xdebug

# composer のインストール
# COPY --from=composer:1.10 /usr/bin/composer /usr/bin/composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1

# ファイルのコピー
COPY ./src /var/www/html
COPY ./docker/app/php.ini /usr/local/etc/php/php.ini
COPY ./docker/app/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
