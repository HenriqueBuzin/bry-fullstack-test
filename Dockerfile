# Base image
FROM php:8.0-apache

# Set working directory
WORKDIR /var/www/html

# Update and install packages
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy application files
COPY app/ /var/www/html/

# Install application dependencies
RUN composer install --no-interaction --no-scripts --no-dev --prefer-dist

# Set environment variables
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Enable Apache modules
RUN a2enmod rewrite headers

# Copy Apache virtual host configuration file
COPY vhost.conf /etc/apache2/sites-available/000-default.conf

# Expose port 80
EXPOSE 80

# Run start.sh
CMD ["apache2-foreground"]