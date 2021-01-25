FROM php:7.4-fpm

COPY wait-for-it.sh /usr/bin/wait-for-it

RUN chmod +x /usr/bin/wait-for-it

RUN apt-get dist-upgrade -y && apt-get update && apt-get install --fix-missing && apt-get upgrade -y && apt-get install -y \
    git \
    unzip \
    nano \
    curl \
    libzip-dev \
    procps \
    acl \
    parallel \
    bash

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.0.0-RC1
RUN export PATH=~/.composer/vendor/bin:$PATH

# Type docker-php-ext-install to see available extensions
# Install opcache and pdo
RUN docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-install opcache \
    && docker-php-ext-install pdo pdo_mysql

# Update pecl repository
RUN pecl channel-update pecl.php.net
# Install APUc
RUN pecl install apcu
RUN echo "extension=apcu.so" > /usr/local/etc/php/conf.d/apcu.ini

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Berlin /etc/localtime
RUN echo 'date.timezone = "Europe/Berlin"' > /usr/local/etc/php/php.ini

#zip archive
RUN pecl install zip
RUN echo "extension=zip.so" > /usr/local/etc/php/conf.d/zip.ini

# ext intl
RUN apt-get install -y libicu-dev \
    && docker-php-ext-install intl

# ext curl for elasticsearch
RUN apt-get install -y libcurl4-openssl-dev \
    && docker-php-ext-install curl

# install imagemagick
RUN apt-get install -y libmagickwand-dev
RUN pecl install imagick
RUN docker-php-ext-enable imagick

# ext gd
RUN docker-php-ext-install gd \
    && docker-php-ext-enable gd

# ext soap
RUN apt-get install -y libxml2-dev  \
    && docker-php-ext-install soap

# install inkscape
RUN apt-get install -y inkscape \
    && ln -s /usr/bin/inkscape /usr/local/bin/inkscape

## install memcached
RUN apt-get install -y memcached libmemcached-dev libmemcached11 build-essential
RUN no | pecl install memcached-3.1.3
RUN docker-php-ext-enable memcached

# math
RUN apt-get install -y libgmp-dev \
	&& ln -s /usr/include/x86_64-linux-gnu/gmp.h /usr/include/gmp.h \
	&& docker-php-ext-install \
		gmp \
		bcmath

# install xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.discover_client_host=On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN apt-get -y install gcc make autoconf libc-dev pkg-config && \
    apt-get -y install libssl-dev && \
    apt-get -y install librabbitmq-dev && \
    pecl install amqp && \
    docker-php-ext-enable amqp

WORKDIR /var/www

CMD composer install ; wait-for-it database:3306 -- bin/console doctrine:migrations:migrate ;  php-fpm

EXPOSE 9000
