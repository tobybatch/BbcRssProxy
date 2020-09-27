FROM php:7.2-apache

MAINTAINER Toby Batch <tobias@neontribe.co.uk>

ADD . /var/www/html
RUN a2enmod rewrite

RUN sed -i "s/html/html\/public/g" /etc/apache2/sites-available/000-default.conf

# vim: set filetype=dockerfile :
