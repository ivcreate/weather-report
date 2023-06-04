FROM php:8.2-fpm

# Arguments defined in docker-compose.yml
ARG user=www-data

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    cron \
    sudo \
    nano \
    libzip-dev \
    zlib1g-dev \
    redis-server

RUN pecl install redis

RUN usermod -aG sudo www-data

RUN echo "www-data ALL=(ALL) NOPASSWD: ALL" >> /etc/sudoers

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip
RUN docker-php-ext-enable redis

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN sed -i 's/www-data:x:82:/www-data:x:1000:/' /etc/group

# Set working directory
WORKDIR /var/www/html

USER $user

COPY laravel-scheduler /etc/cron.d/weather_cron
RUN sudo chmod 0777 /etc/cron.d/weather_cron
RUN crontab /etc/cron.d/weather_cron

RUN sudo usermod -u 1000 www-data & sudo groupmod -g 1000 www-data
