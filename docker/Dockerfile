FROM php:8.2-apache-buster
ENV WWW_ROOT=/var/www/
ENV APP_ENV=dev
ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update
RUN apt-get install -y curl cron nano git zlib1g-dev libyaml-dev libssl-dev openssl libmcrypt-dev libxml2-dev libcurl4-openssl-dev libbz2-dev libzip-dev unzip
RUN pecl install yaml-2.2.2 && pecl install mongodb
RUN docker-php-ext-enable yaml mongodb
RUN docker-php-ext-install curl \
    && docker-php-ext-install soap \
    && docker-php-ext-install bz2 \
    && docker-php-ext-install opcache \
    && docker-php-ext-install zip \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

RUN echo "date.timezone=Europe/Warsaw" > /usr/local/etc/php/conf.d/10-timezone.ini \
    && echo "memory_limit=1G" > /usr/local/etc/php/conf.d/20-memory.ini

RUN mkdir -p ${WWW_ROOT}html
RUN chown www-data:www-data -R ${WWW_ROOT}

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY apache/ /etc/apache2/sites-available
RUN a2enmod rewrite

RUN mkdir -p ${WWW_ROOT}/html/var/cache
RUN mkdir -p ${WWW_ROOT}/html/var/log
RUN mkdir -p ${WWW_ROOT}/html/public/photos
RUN chmod -R 777 ${WWW_ROOT}/html/var/cache
RUN chmod -R 777 ${WWW_ROOT}/html/var/log

COPY ./docker/run.sh /
RUN chmod 755 /run.sh

VOLUME /run
EXPOSE 80
ENTRYPOINT /run.sh

