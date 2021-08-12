FROM php:8.0.8-apache
WORKDIR /var/www/html
VOLUME /var/www/html

# Actualizar paquetes
RUN apt-get update && apt-get upgrade -y
# Instalar dependencias
RUN apt-get install -y apt-utils unzip wget git npm libzip-dev libpng-dev \
    && npm i -g typescript ts-cleaner
# Instalar composer:
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#####################################################################
# Extensiones de PHP                                                #
# ################################################################# #
# Incluye todas las dependencias de Laravel y XDebug, una           #
# herramienta para debuggear PHP.                                   #
# Acá una lista de extensiones PHP y cómo instalarlas:              #
# https://gist.github.com/hoandang/88bfb1e30805df6d1539640fc1719d12 #
#####################################################################
RUN pecl install xdebug && docker-php-ext-enable xdebug \
    && docker-php-ext-install mysqli bcmath zip gd

EXPOSE 80