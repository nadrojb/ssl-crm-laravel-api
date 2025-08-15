FROM php:8-fpm-alpine

ENV PHPGROUP=laravel
ENV PHPUSER=laravel

RUN addgroup -S ${PHPGROUP} && adduser -S -G ${PHPGROUP} -s /bin/sh ${PHPUSER}

# Run PHP-FPM as our user/group
RUN sed -i "s/^user = .*/user = ${PHPUSER}/" /usr/local/etc/php-fpm.d/www.conf \
 && sed -i "s/^group = .*/group = ${PHPGROUP}/" /usr/local/etc/php-fpm.d/www.conf

RUN mkdir -p /var/www/html/public

RUN docker-php-ext-install pdo pdo_mysql

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]