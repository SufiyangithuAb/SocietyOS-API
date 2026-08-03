FROM dunglas/frankenphp:1-php8.2

WORKDIR /app

# Install required PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy only Composer files first (better Docker caching)
COPY super_admin/composer.json super_admin/composer.lock /app/super_admin/

# Install PHP dependencies
WORKDIR /app/super_admin
RUN composer install --no-dev --optimize-autoloader

# Copy the rest of the project
WORKDIR /app
COPY . /app

EXPOSE 80

CMD ["frankenphp", "run", "--config", "/app/Caddyfile"]