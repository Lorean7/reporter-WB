FROM php:8.1.5-fpm

RUN docker-php-ext-install mysqli

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y \
    unzip \
    curl \
    libzip-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip \
    && rm -rf /var/lib/apt/lists/*

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 777 /var/www/html

ENV NVM_DIR /root/.nvm
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.37.2/install.sh | bash

RUN . "$NVM_DIR/nvm.sh" && nvm install 20 && nvm use 20 && nvm alias default 20
