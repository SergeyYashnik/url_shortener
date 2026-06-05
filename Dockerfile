FROM php:8.3-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev libzip-dev libicu-dev libonig-dev libxml2-dev

RUN docker-php-ext-install -j$(nproc) \
    pdo_pgsql pgsql mbstring zip intl bcmath pcntl

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN chown -R www-data:www-data /var/www/html

USER www-data

CMD ["php-fpm"]
