# Leeloo multistage

# Stage 0
FROM composer:1.7.0 AS composer

# Stage 1
FROM php:7.3.10-zts-alpine3.10

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN docker-php-ext-install -j$(nproc) pdo_mysql

WORKDIR /app

EXPOSE 8000

CMD ["./entrypoint.sh"]
