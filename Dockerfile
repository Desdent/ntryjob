# Usa la imagen oficial de PHP 8.2 con el servidor Apache preinstalado
FROM php:8.2-apache

# Instala las extensiones necesarias de PHP para conectar con MySQL
RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl && \
    docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instala Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Configura Xdebug para Windows + Docker Desktop
RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.log=/tmp/xdebug.log" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Copia TODOS los archivos del proyecto al directorio raíz del servidor web (Apache)
COPY . /var/www/html

# Si usas Composer para gestionar dependencias, lo copiamos aquí de la imagen oficial de Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer require phpmailer/phpmailer

# Establece el directorio base de trabajo
WORKDIR /var/www/html

# Instala dependencias de Composer si existe composer.json
RUN composer install || true

RUN a2enmod rewrite

# Expone el puerto 80 de Apache dentro del contenedor
EXPOSE 80
