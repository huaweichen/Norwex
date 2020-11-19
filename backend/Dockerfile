FROM php:7.4-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql sockets
RUN curl -sS https://getcomposer.org/installer | php -- \
     --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . /app
RUN composer install
RUN touch /app/storage/norwex.sqlite && \
    cp /app/.env.example /app/.env && \
    php artisan key:generate && \
    php artisan migrate && \
    php artisan db:seed

CMD php artisan serve --host=0.0.0.0 --port=8000
EXPOSE 8000
