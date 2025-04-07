# Gunakan image PHP terbaru yang sudah terinstal Apache
FROM php:7.3-apache

# Install extension yang dibutuhkan Laravel (MySQL, PDO, dll)
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy seluruh file project ke dalam container
COPY . /var/www/html

# Salin file konfigurasi Apache yang sudah dimodifikasi
COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf

# Jalankan artisan storage:link untuk membuat symbolic link
RUN php /var/www/html/artisan storage:link
#RUN php /var/www/html/artisan config:clear
RUN php /var/www/html/artisan cache:clear
#RUN php /var/www/html/artisan config:cache
#RUN sleep 10 && php /var/www/htm/artisan migrate --force
RUN cp .env.qa .env && php artisan config:clear && php artisan cache:clear

# Set permission folder
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Enable mod_rewrite untuk Apache
RUN a2enmod rewrite

# Jalankan perintah Laravel saat container dimulai
CMD ["bash", "-c", "apache2-foreground"]
