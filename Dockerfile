FROM dunglas/frankenphp:1-php8.2

WORKDIR /app

COPY ./api /app

RUN docker-php-ext-install pdo pdo_mysql

EXPOSE 80

CMD ["frankenphp", "run", "--config", "/app/Caddyfile"]
