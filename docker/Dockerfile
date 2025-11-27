# Sistema_Inundaciones/docker/Dockerfile
FROM php:8.1-fpm

# Instalar dependencias del sistema PRIMERO
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

# Instalar extensiones de PHP DESPUÉS
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crear usuario para la aplicación
RUN groupadd -g 1000 www && \
    useradd -u 1000 -ms /bin/bash -g www www

# Crear directorio de trabajo
RUN mkdir -p /var/www/html/backend

# Cambiar al usuario www
USER www

# Directorio de trabajo
WORKDIR /var/www/html/backend