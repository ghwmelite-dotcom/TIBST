FROM php:8.2-apache

# Install PHP extensions required by the CMS
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libwebp-dev libfreetype6-dev \
    default-mysql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install gd pdo pdo_mysql fileinfo \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# PHP configuration for file uploads
RUN echo "upload_max_filesize = 20M\npost_max_size = 25M\nmax_execution_time = 300" \
    > /usr/local/etc/php/conf.d/tibst.ini

# Copy application files
COPY . /var/www/html/

# Ensure uploads directory exists and is writable
RUN mkdir -p /var/www/html/uploads \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/uploads

# Copy entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]
