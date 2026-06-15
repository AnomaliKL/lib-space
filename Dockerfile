FROM php:8.4-apache

# Instal dependensi sistem dan ekstensi PHP yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd

# Aktifkan mod_rewrite Apache untuk routing Laravel
RUN a2enmod rewrite

# Atur DocumentRoot Apache ke folder public Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Instal Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Salin semua file proyek ke dalam container
WORKDIR /var/www/html
COPY . .

# Jalankan composer install untuk menginstal vendor backend
RUN composer install --no-dev --optimize-autoloader

# Atur permissions folder storage dan cache agar bisa ditulis oleh Apache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80