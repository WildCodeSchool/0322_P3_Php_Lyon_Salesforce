#
# Prep App's PHP Dependencies
#
FROM composer/composer:2-bin as composer
FROM composer:2.5.1 as vendor
WORKDIR /app

COPY composer.json composer.json
COPY composer.lock composer.lock
RUN composer install --no-scripts

#
# Prep App's Frontend CSS & JS now
# so some symfony UX dependencies can access to vendor
#
FROM node:18-alpine as node
WORKDIR /app
COPY --from=vendor /app/vendor vendor/
COPY package.json package.json
COPY yarn.lock yarn.lock
COPY . .
RUN yarn install
RUN yarn build
#RUN ls public

FROM php:8.2-fpm-alpine as phpserver

# add cli tools
RUN apk update \
    && apk upgrade \
    && apk add nginx

RUN apk add --no-cache \
      libzip-dev \
      zip \
    && docker-php-ext-install zip

# silently install 'docker-php-ext-install' extensions
RUN set -x

RUN docker-php-ext-install pdo_mysql bcmath > /dev/null

# Install INTL
RUN apk add icu-dev
RUN docker-php-ext-configure intl && docker-php-ext-install intl && docker-php-ext-enable intl

COPY nginx.conf /etc/nginx/nginx.conf

COPY php.ini /usr/local/etc/php/conf.d/local.ini
RUN cat /usr/local/etc/php/conf.d/local.ini


WORKDIR /var/www
COPY . /var/www/
COPY --from=vendor /app/vendor /var/www/vendor
COPY --from=composer /composer /usr/bin/composer
COPY --from=node /app/public/build /var/www/public/build

EXPOSE 80

COPY docker-entry.sh /etc/entrypoint.sh
ENTRYPOINT ["sh", "/etc/entrypoint.sh"]
