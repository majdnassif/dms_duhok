# Use an official PHP runtime
FROM php:8.2-apache
# Enable Apache modules
RUN a2enmod rewrite
# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    libicu-dev \
    libxml2-dev \
    libonig-dev \
    libcurl4-openssl-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    redis-server \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    pdo_pgsql \
    mysqli \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    intl \
    opcache \
    zip \
    soap \
    xml \
    curl \
    && docker-php-ext-enable opcache

RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN echo "xdebug.discover_client_host=0" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=1" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo 'xdebug.idekey="PHPSTORM"' >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo 'xdebug.client_host="host.docker.internal"' >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/xdebug.ini

# Clean up
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Set the working directory to /var/www/html
WORKDIR /var/www/html
# Make port 80 available to the world outside this container
EXPOSE 80
EXPOSE 443
EXPOSE 3306
EXPOSE 9003