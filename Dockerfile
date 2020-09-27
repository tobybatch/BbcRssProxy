FROM composer:1.10 AS composer
RUN composer require --working-dir=/var/www/html hirak/prestissimo

FROM php:7.2-apache
MAINTAINER Toby Batch <tobias@neontribe.co.uk>
ADD . /var/www/html
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN apt update && apt install -y git
RUN mkdir /composer  && \
    a2enmod rewrite && \
    sed -i "s/html/html\/public/g" /etc/apache2/sites-available/000-default.conf && \
    composer install --working-dir=/var/www/html --optimize-autoloader

# vim: set filetype=dockerfile :
