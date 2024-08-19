FROM php:8.3.4-apache

# Install Node.js and npm
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - && \
    apt-get update && \
    apt-get install -y nodejs npm && \
    rm -rf /var/lib/apt/lists/*

# Install dependencies and PHP extensions
RUN apt-get update && apt-get install -y libfreetype-dev libjpeg62-turbo-dev libpng-dev libpq-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy application files
COPY . /var/www/html

# Install additional PHP extension
RUN apt-get update && apt-get install -y libzip-dev && docker-php-ext-install zip

WORKDIR /etc/apache2/sites-available

# Configure Apache
RUN a2enmod rewrite && a2enmod headers

# Copy Apache configuration
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Change working directory
WORKDIR /var/www/html/

RUN rm -rf 000-default.conf \
    && rm -rf Dockerfile

# Change working directory
WORKDIR /var/www/html/Time-Tracker/public

RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Install NPM dependencies
RUN npm install
RUN composer install

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]