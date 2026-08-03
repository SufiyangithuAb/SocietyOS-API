FROM dunglas/frankenphp:1-php8.2

WORKDIR /app

# Install system packages required by Composer
RUN apt-get update && apt-get install -y \
    unzip \
    zip \
    git \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy Composer files first
COPY super_admin/composer.json super_admin/composer.lock /app/super_admin/

# Install PHP dependencies
WORKDIR /app/super_admin
RUN composer install --no-dev --optimize-autoloader

# Copy project
WORKDIR /app
COPY . /app

EXPOSE 80

CMD ["frankenphp", "run", "--config", "/app/Caddyfile"]