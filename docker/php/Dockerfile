FROM php:8.2-fpm

# create user
RUN groupadd -g 1000 laravel
RUN useradd -u 1000 -ms /bin/bash -g laravel laravel

WORKDIR /var/project

RUN apt-get update \
    && apt-get install -y libpq-dev \
    && apt-get install -y zip \
    && apt-get install -y unzip \
    && apt-get install -y git \
    && apt-get install -y curl \
    && apt-get install -y nano \
    # Extensions
    && docker-php-ext-install pdo_pgsql \
    && docker-php-ext-install pgsql \
    && docker-php-ext-install zip \
    # Enable extensions
    && docker-php-ext-enable pdo_pgsql \
    && docker-php-ext-enable pgsql \
    # install
    && apt-get -y install imagemagick php8.2-imagick php8.2-pcntl php8.2-gd php8.2-pgsql php8.2-sqlite nano php8.2-redis php-bcmath php8.2-zmq, pdo_pgsql pdo \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql

#region Amqp
RUN apt-get update && apt-get install -y librabbitmq-dev libssh-dev \
    && docker-php-ext-install opcache bcmath sockets \
    && pecl install amqp \
    && docker-php-ext-enable amqp
#endregion

# RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY ./php.ini $PHP_INI_DIR/php.ini
# Use the default production configuration
