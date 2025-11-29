# Sistema_Inundaciones/docker/Dockerfile
FROM php:8.3-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensiones de PHP
RUN docker-php-ext-install pdo pdo_mysql mysqli mbstring exif pcntl bcmath gd zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crear usuario no-root
RUN groupadd -g 1000 www && \
    useradd -u 1000 -ms /bin/bash -g www www

# Configurar permisos y directorio de trabajo
RUN mkdir -p /var/www/html/backend
WORKDIR /var/www/html/backend

# Copiar composer.json primero (optimización de caché)
COPY composer.json composer.lock ./

# Instalar dependencias
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Crear usuario y asegurar permisos (puede reforzarse en entrypoint)
RUN chown -R www:www /var/www/html/backend

# Cambiar al usuario no-root
USER www

# Copiar resto del código (después de composer install)
COPY --chown=www:www . .

# Asegurar permisos en runtime (crítico para Laravel)
RUN mkdir -p storage/logs \
    && chmod -R 775 storage bootstrap/cache

# Configuración opcional de PHP (ejemplo)
RUN echo "date.timezone = UTC" >> /usr/local/etc/php/conf.d/custom.ini

# Arrancar PHP-FPM
CMD ["php-fpm"]