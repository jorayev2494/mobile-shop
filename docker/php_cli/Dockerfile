FROM php:8.2-cli-alpine

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install selected extensions and other stuff

RUN apt-get update \
    && apt-get install -y libpq-dev \
    # Extensions
    && docker-php-ext-install pdo_pgsql \
    && docker-php-ext-install pgsql \
    # Enable extensions
    && docker-php-ext-enable pdo_pgsql \
    && docker-php-ext-enable pgsql \
    # Install
    && apt-get -y --no-install-recommends install imagemagick php8.1-imagick php8.1-pgsql pdo_pgsql pdo nano php8.1-gd php8.1-redis php8.1-bcmath php8.1-zmq \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

#region Postgres Extensions
RUN set -ex \
  && apk --no-cache add \
    postgresql-dev

RUN docker-php-ext-install pdo pdo_pgsql

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
#endregion

# Composer installing
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/ \
    && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer

WORKDIR /var/project

# CMD [ "sh" ]
# RUN rm -rf /var/project/docker && chmod -R 777 /var/project/bootstrap && chmod -R 777 /var/project/storage