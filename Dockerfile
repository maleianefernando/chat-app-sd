FROM php:8.3-fpm

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libjpeg-dev libonig-dev libxml2-dev zip unzip \
    libzip-dev libpq-dev libssl-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip bcmath gd

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Criar diretório
WORKDIR /var/www

# Copia o projeto
COPY . .

# Instala dependências PHP
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Garante permissões
RUN chmod -R 775 storage bootstrap/cache

RUN php artisan config:cache && \
    php artisan migrate --force

EXPOSE 8000

# Inicia servidor Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
