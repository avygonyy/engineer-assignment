FROM php:7.2-apache
WORKDIR /var/www
RUN apt-get update && apt-get install -y libmcrypt-dev \
mariadb-client libmagickwand-dev wget --no-install-recommends \
&& pecl install imagick \
&& docker-php-ext-enable imagick \
&& docker-php-ext-install pdo_mysql zip pdo pdo_mysql mysqli exif mbstring

    RUN apt-get install -y --no-install-recommends \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libxpm-dev \
    libvpx-dev \
    && docker-php-ext-configure gd \
    --with-freetype-dir=/usr/lib/x86_64-linux-gnu/ \
    --with-jpeg-dir=/usr/lib/x86_64-linux-gnu/ \
    --with-xpm-dir=/usr/lib/x86_64-linux-gnu/ \
    --with-vpx-dir=/usr/lib/x86_64-linux-gnu/ \
    && docker-php-ext-install gd

RUN yes | pecl install xdebug \
&& echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
&& echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
&& echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

RUN apt install -y git

# Workaround for write permission on write to MacOS X volumes
# See https://github.com/boot2docker/boot2docker/pull/534
RUN usermod -u 1000 www-data
# Enable Apache mod_rewrite
RUN a2enmod rewrite
# Enable Apache mod_rewrite
RUN a2enmod headers
# Enable Apache mod_rewrite
RUN a2enmod expires
COPY ./apache2.conf /etc/apache2/sites-available/apache2.conf
RUN a2ensite apache2
RUN a2dissite 000-default.conf
#RUN service apache2 reload

RUN apt install -y mc

