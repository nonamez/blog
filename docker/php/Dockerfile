FROM php:8.1.4-fpm-alpine3.14

# Add Build Dependencies
RUN apk update && apk add --no-cache --virtual .build-deps  \
    $PHPIZE_DEPS \
    # imagemagick-dev \
    zlib-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libxml2-dev \
    bzip2-dev \
    zip

# Add Production Dependencies
RUN apk add --update --no-cache \
    # supervisor \
    # imagemagick \
    icu-dev \
    freetype-dev \
    mysql-client \
    libzip-dev

RUN pear update-channels \
    pecl update-channels

RUN pecl install redis \
    docker-php-ext-enable redis 

# RUN docker-php-ext-enable imagick

# Configure & Install Extension
RUN docker-php-ext-install \
    intl \
    bz2 \
    pcntl \
    bcmath \
    zip 

# MySQL Support
RUN docker-php-ext-install mysqli pdo pdo_mysql

# PostgreSQL
# RUN apk add --no-cache libpq postgresql-dev && docker-php-ext-install pdo pdo_pgsql pgsql

# Composer
COPY --from=composer:2.3.7 /usr/bin/composer /usr/bin/composer

# Remove Build Dependencies
RUN apk del -f .build-deps

COPY ./custom-docker-entrypoint /usr/local/bin/custom-docker-entrypoint
COPY ./conf/* /usr/local/etc/php/conf.d/
COPY ./fpm/* /usr/local/etc/php-fpm.d

COPY ./supervisor/supervisord.conf /etc/supervisor/supervisord.conf
COPY ./supervisor/conf /etc/supervisor/conf.d

ENTRYPOINT ["custom-docker-entrypoint"]

# Setup Working Dir
WORKDIR /var/www

EXPOSE 9000