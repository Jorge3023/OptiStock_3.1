# Usamos una imagen oficial de PHP con el servidor Apache
FROM php:8.2-apache

# Habilitar mod_rewrite de Apache (Obligatorio para que funcionen las rutas de Laravel)
RUN a2enmod rewrite

# Instalar herramientas del sistema y Node.js (necesario para Vite y Tailwind)
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Instalar extensiones de PHP que usa Laravel
RUN docker-php-ext-install pdo_mysql zip

# Configurar Apache para que lea la carpeta "public" de Laravel en lugar de la raíz
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Descargar e instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Movernos a la carpeta del servidor
WORKDIR /var/www/html

# Copiar todos los archivos de tu repositorio al servidor
COPY . .

# Instalar las dependencias de Laravel
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Instalar las dependencias de frontend y compilar Vite
RUN npm install
RUN npm run build

# Dar los permisos correctos a las carpetas que Laravel necesita modificar
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache