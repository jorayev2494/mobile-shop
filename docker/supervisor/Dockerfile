FROM php:8.2-cli

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install selected extensions and other stuff

#region Amqp
# RUN apt-get update \
#     && apt-get install -y librabbitmq-dev libssh-dev \
#     && docker-php-ext-install opcache bcmath sockets \
#     && pecl install amqp \
#     && docker-php-ext-enable amqp

RUN apt-get update \
    && apt-get install -y \
        librabbitmq-dev \
        libssh-dev \
    && docker-php-ext-install \
        bcmath \
        sockets \
    && pecl install amqp \
    && docker-php-ext-enable amqp

#endregion

RUN apt-get update \
    && apt-get install -y libpq-dev \
    && apt-get install -y libjpeg-dev \
    && apt-get install -y zip \
    && apt-get install -y unzip \
    && apt-get install -y git \
    && apt-get install -y curl \
    && apt-get install -y nano \
    && postgresql-dev \
    # Install Supervisor
    && apt-get update && apt-get -y install supervisor \
    # Extensions
    && docker-php-ext-install pdo_pgsql \
    && docker-php-ext-install pgsql \
    # Enable extensions
    && docker-php-ext-enable pdo_pgsql \
    && docker-php-ext-enable pgsql \
    # Image extensions
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install gd \
    # Install
    && apt-get -y --no-install-recommends install imagemagick php8.2-imagick php8.2-pgsql pdo_pgsql pdo nano php8.2-gd php8.2-redis php8.2-bcmath php8.2-zmq \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Create image
# RUN apt-get install docker-php-ext-configure gd --with-jpeg \
    # && docker-php-ext-install gd

#region Postgres Extensions
# RUN set -ex \
#   && apk --no-cache add \
#     postgresql-dev

RUN docker-php-ext-install pdo pdo_pgsql

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
#endregion

RUN apt-get update && apt-get -y install supervisor

WORKDIR /var/project

EXPOSE 9001

# https://serverfault.com/questions/211525/supervisor-not-loading-new-configuration-files
# COPY configs/supervisord.conf /etc/supervisor/
COPY configs/ /etc/supervisor/

CMD ["supervisord", "-c", "/etc/supervisor/supervisord.conf", "-n"]
# CMD ["/usr/bin/supervisord"]
