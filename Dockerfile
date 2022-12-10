FROM node:16.18.0-alpine3.16 AS node
FROM php:8.1.8-fpm-alpine3.16

RUN set -x && apk update && apk upgrade \
    && apk add --update --no-cache \
    bash \
    curl \
    supervisor \
    && rm -rf /tmp/* /var/cache/apk/*

# RUN apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev

# RUN docker-php-ext-install -j$(nproc)
# RUN docker-php-ext-install pcntl
# RUN docker-php-ext-install pgsql pdo_pgsql ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/


ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions pgsql pdo_pgsql redis pcntl sodium

# RUN groupadd -g 1000 www
# RUN useradd -u 1000 -ms /bin/bash -g www www
RUN addgroup -g 1000 www && adduser -D -u 1000 www -G www
WORKDIR /var/www/html

COPY . /var/www/html
# RUN composer install

# RUN chmod -R 777 /var/www/html
COPY --from=composer/composer /usr/bin/composer /usr/bin/composer


USER www

CMD php artisan serve --host=0.0.0.0 --port=8000
EXPOSE 8000
