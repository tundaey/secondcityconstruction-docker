FROM php:5.6-apache
COPY . /var/www/html
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite
RUN apt-get update -y && apt-get install -y libfreetype6-dev libpng-dev libjpeg62-turbo-dev
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ 
RUN docker-php-ext-install \
		mysqli \
		opcache \
        gd \
        pdo_mysql
