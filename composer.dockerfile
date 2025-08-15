FROM composer:2

ENV COMPOSERUSER=laravel
ENV COMPOSERGROUP=laravel

RUN adduser -g ${COMPOSERUSER} -s /bin/sh -D ${COMPOSERGROUP}