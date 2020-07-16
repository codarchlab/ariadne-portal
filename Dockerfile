FROM php:7.1-apache

# Setup Apache and point to Ariadne docroot
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Setup log directory
ENV APACHE_LOG_DIR /var/www/html/storage/logs

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

COPY . /var/www/html
RUN rm -rf vendor

# Enable Apache SSL module
RUN a2enmod rewrite
RUN a2enmod ssl

# Get needed stuff
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer
RUN apt-get update && \
    apt-get upgrade -y
RUN apt-get install -y git
RUN apt-get install -y zip
RUN apt-get install -y unzip
#RUN apt-get install -y openssl
#RUN docker-php-ext-install pdo_mysql mbstring

# Encryption stuff
RUN apt-get install -y libmcrypt-dev
RUN docker-php-ext-install mcrypt

# Nodejs, NPM, Gulp
RUN curl -sL https://deb.nodesource.com/setup_10.x | bash -
#RUN apt-get install -y nodejs
#RUN bower install --allow-root 
#RUN npm install -g gulp

# Additional 'nice to have'
RUN apt-get install -y vim

# Install xdebug.
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Add xdebug configuration.
COPY docker/xdebug/xdebug.ini /usr/local/etc/php/conf.d/

COPY composer.json /var/www/html/
RUN composer install --no-scripts;

# Clear cache
RUN php artisan config:clear 
RUN php artisan cache:clear
RUN php artisan route:clear
RUN php artisan view:clear 

# Set www-data to folders
RUN chown -R www-data:www-data /var/www/html/storage/framework/views
RUN chown -R www-data:www-data /var/www/html/storage/framework/sessions
RUN chown -R www-data:www-data /var/www/html/storage/logs

RUN echo 'alias ll="ls -la"' >> ~/.bashrc

EXPOSE 80