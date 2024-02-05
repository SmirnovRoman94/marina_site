FROM php:8.3-fpm
RUN apt-get update && apt-get install -y \
      apt-utils \
      libpq-dev \
      libpng-dev \
      libzip-dev \
      zip unzip \
      git && \
      docker-php-ext-install pdo_mysql && \
      docker-php-ext-install bcmath && \
      docker-php-ext-install gd && \
      docker-php-ext-install zip && \
      docker-php-ext-install exif && \
      apt-get clean && \
      rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY php.ini /etc/php/8.3/cli/conf.d/99-etc.ini
COPY local.ini /usr/local/etc/php/php.ini
# Install composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


COPY docker-compose.sh /docker-compose.sh
RUN chmod +x /docker-compose.sh
CMD ["/docker-compose.sh"]

WORKDIR /var/www/laravel

RUN composer self-update
