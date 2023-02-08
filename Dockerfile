#Comenzamos con la imagen base - version 7.1.5
FROM php:7.3.7-apache

#RUN printf "deb http://archive.debian.org/debian/ jessie main\ndeb-src http://archive.debian.org/debian/ jessie main\ndeb http://security.debian.org jessie/updates main\ndeb-src http://security.debian.org jessie/updates main" > /etc/apt/sources.list

#instala todas las dependencias del sistema
RUN apt-get update && apt-get install -y \
        libicu-dev \
        libpq-dev \
        libmcrypt-dev \
        git \
        zip \
        unzip \
        curl \
        sudo \
        libbz2-dev \
        libpng-dev \
        libjpeg-dev \
        libreadline-dev \
        libfreetype6-dev \
        g++

#aknsckl
RUN apt-get install -y zip libzip-dev \
  && docker-php-ext-configure zip --with-libzip \
  && docker-php-ext-install zip
# 2. apache configs + document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf


# 3. mod_rewrite for URL rewrite and mod_headers for .htaccess extra headers like Access-Control-Allow-Origin-
RUN a2enmod rewrite headers

# 4. start with base php config, then add extensions
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN docker-php-ext-install \
    bz2 \
    intl \
    iconv \
    bcmath \
    opcache \
    calendar \
    mbstring \
    pdo_mysql \
    zip

#install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

#establece la carpeta de aplicaciones como una variable de entorno
ENV APP_HOME /var/www/html

#cambiar el uid y el gid de apache al usuario de la aplicación uid / gid
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

#cambia la raíz web_root a laravel / var / www / html / public folder
RUN sed -i -e "s/html/html\/public/g" /etc/apache2/sites-enabled/000-default.conf

# habilitar la reescritura del módulo apache
RUN a2enmod rewrite

#copiar archivos fuente y ejecutar compositor
COPY / $APP_HOME

# instalar todas las dependencias de PHP
RUN composer install --no-interaction

# Install Node.js
# RUN curl -sL https://deb.nodesource.com/setup_12.x | bash - && \
#  apt-get install -y nodejs

#cambiar la propiedad de nuestras aplicaciones
RUN chown -R www-data:www-data $APP_HOME

RUN chmod 755 $APP_HOME
