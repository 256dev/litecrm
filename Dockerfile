FROM composer:1.9.1 as composer

COPY . /app

RUN composer install

FROM node:14.5.0-alpine as node

WORKDIR /app

COPY --from=composer /app /app

RUN npm install && npm run prod \
	&& rm -rf node_modules

FROM php:7.4.2-apache

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
	&& sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN apt update -y \
	&& apt-get install -y libzip-dev zip \
	&& rm -rf /var/lib/apt/lists/* \
	&& docker-php-ext-install pdo pdo_mysql zip

RUN a2enmod rewrite

COPY --from=node /app/ /var/www/html

RUN chown -R www-data:www-data /var/www

USER www-data