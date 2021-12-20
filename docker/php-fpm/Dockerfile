FROM php:7.4.23-fpm

WORKDIR /application

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y --no-install-recommends \
    vim \
    git \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev \
    librabbitmq-dev \
    libssh-dev

RUN docker-php-ext-install \
    zip \
    intl \
    opcache \
    bcmath \
    sockets \
    pdo pdo_mysql

RUN pecl install \
    apcu \
    amqp

RUN docker-php-ext-enable \
    opcache \
    apcu \
    amqp

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Alias
RUN echo 'alias sf="bin/console"' >> ~/.bashrc

COPY php-ini-overrides.ini /usr/local/etc/php/conf.d/php-ini-overrides.ini

## PHP-FPM packages need a nudge to make them docker-friendly
#COPY overrides.conf /etc/php/7.3/fpm/pool.d/z-overrides.conf
