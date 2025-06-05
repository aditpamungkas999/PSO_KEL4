# Gunakan base image PHP dengan Apache
FROM php:8.1-apache

# Install ekstensi PHP & tools dasar
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    zip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg

RUN docker-php-ext-install mysqli pdo pdo_mysql zip gd intl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy source code aplikasi
COPY . /var/www/html

# Beri hak akses
RUN chown -R www-data:www-data /var/www/html

# Aktifkan Apache mod_rewrite
RUN a2enmod rewrite

# Konfigurasi Apache (opsional, jika perlu)
COPY apache.conf /etc/apache2/sites-enabled/000-default.conf

# Set working directory
WORKDIR /var/www/html

# Install Composer (jika perlu, untuk dependency PHP)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# # Jalankan Composer install (opsional)
# RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Expose port
EXPOSE 80
