FROM php:8.2-fpm

RUN apt-get update \
    && apt-get install -y \
    libonig-dev \
    libzip-dev \
    zip \
    nodejs \
    npm 

RUN docker-php-ext-install \
    zip \
    pdo_mysql \
    mbstring 

#redis
RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

#change dir
WORKDIR /var/www

#Copy DIR to container
COPY . /var/www

#Get Composer Installer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#Install App deps
#RUN composer install && npm i

#clean lists
RUN apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

#Set User
RUN useradd -ms /bin/bash admin
RUN chown -R admin:admin /var/www/
RUN chmod 777 /var/www/
USER admin

# Expose port 9000 
EXPOSE 9000
# Start server
CMD ["php-fpm"]
