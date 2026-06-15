FROM php:8.4-apache

# 1. Instal dependensi sistem dan ekstensi PHP yang dibutuhkan Laravel
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

# 2. Aktifkan mod_rewrite Apache untuk routing Laravel
RUN a2enmod rewrite

# 3. Atur DocumentRoot Apache ke folder public Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 4. Instal Node.js & NPM (Untuk Build Tailwind)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# 🔥 PERBAIKAN KRUSIAL: Matikan MPM Event/Worker penyusup agar tidak bentrok
RUN a2dismod mpm_event || true \
    && a2dismod mpm_worker || true \
    && a2enmod mpm_prefork || true

# 5. Instal Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 6. Salin semua file proyek ke dalam container
WORKDIR /var/www/html
COPY . .

# 7. Jalankan composer install untuk menginstal vendor backend
RUN composer install --no-dev --optimize-autoloader

# 8. Jalankan NPM Install & NPM Build untuk compile Tailwind CSS
RUN npm install && npm run build

# 9. Atur permissions folder storage dan cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80