# Usa la imagen oficial de PHP 8.2 con el servidor Apache preinstalado
FROM php:8.2-apache

# Instala las extensiones necesarias de PHP para conectar con MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Copia TODOS los archivos del proyecto al directorio raíz del servidor web (Apache)
COPY . /var/www/html

# Si usas Composer para gestionar dependencias, lo copiamos aquí de la imagen oficial de Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Establece el directorio base de trabajo
WORKDIR /var/www/html

# Instala dependencias de Composer si existe composer.json
RUN composer install || true

# Expone el puerto 80 de Apache dentro del contenedor
EXPOSE 80

