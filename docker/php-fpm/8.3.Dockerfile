FROM php:8.3-fpm

ENV DEBIAN_FRONTEND noninteractive

# Install required packages
RUN apt-get update && apt-get install -y --no-install-recommends \
        curl \
        libmemcached-dev \
        libz-dev \
        libpq-dev \
        libjpeg62-turbo-dev \
        libpng16-16 \
        libfreetype6-dev \
        unzip \
        zip \
        libzip-dev \
        zlib1g-dev \
        nodejs \
        npm \
        build-essential \
        libicu-dev \
        g++ \
        git \
        libssl-dev \
        libgmp-dev \
        libxml2-dev;

# Clean up
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-install pdo_mysql mysqli opcache soap bcmath gmp pdo_pgsql pgsql

RUN pecl install redis && docker-php-ext-enable redis

RUN docker-php-ext-configure zip && docker-php-ext-install zip
RUN npm install -g yarn

RUN docker-php-ext-configure gd \
    --with-jpeg-dir=/usr/include/ \
    --with-freetype-dir=/usr/include/; \
    docker-php-ext-install gd; \
    php -r 'var_dump(gd_info());'

RUN docker-php-ext-configure intl && docker-php-ext-install intl

COPY ./opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Composer setup
RUN curl -s -k https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

USER root

# Clean up
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    rm /var/log/lastlog /var/log/faillog

RUN usermod -u 1000 www-data

WORKDIR /var/www

CMD ["php-fpm"]

EXPOSE 9000