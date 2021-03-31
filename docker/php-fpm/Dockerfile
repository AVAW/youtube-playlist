FROM php:7.4-fpm
WORKDIR "/application"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev

RUN docker-php-ext-install \
    zip \
    intl \
    opcache \
    pdo pdo_mysql

RUN pecl install \
    apcu

RUN docker-php-ext-enable \
    opcache \
    apcu

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

#RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
#    && php -r "if (hash_file('sha384', 'composer-setup.php') === 'e0012edf3e80b6978849f5eff0d4b4e4c79ff1609dd1e613307e16318854d24ae64f26d17af3ef0bf7cfb710ca74755a') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
#    && php composer-setup.php --filename=composer \
#    && php -r "unlink('composer-setup.php');" \
#    && mv composer /usr/local/bin/composer

# Install extensions and other stuff
#RUN apt-get install \
#    && php-memcached php7.4-mysql php-redis php-xdebug php7.4-bcmath  php-yaml \
#    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN printf '[PHP]\ndate.timezone = "Europe/Warsaw"\n' > /usr/local/etc/php/conf.d/tzone.ini

## PHP-FPM packages need a nudge to make them docker-friendly
#COPY overrides.conf /etc/php/7.3/fpm/pool.d/z-overrides.conf
