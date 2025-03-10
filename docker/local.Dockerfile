FROM composer:2.8.3 AS builder

COPY .. /app

RUN composer install --ignore-platform-reqs --dev

FROM dunglas/frankenphp:alpine

RUN install-php-extensions \
        xdebug

ENV SERVER_NAME=:80

COPY --from=builder /app /app

