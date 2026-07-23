FROM dunglas/frankenphp:1-php8.2

WORKDIR /app

RUN docker-php-ext-install pdo pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy PHP API
COPY ./api /app

# Copy Caddy configuration separately
COPY ./Caddyfile /app/Caddyfile

RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --optimize-autoloader

EXPOSE 80

CMD ["frankenphp", "run", "--config", "/app/Caddyfile"]
