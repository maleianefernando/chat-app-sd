FROM php:8.3-apache

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libjpeg-dev libonig-dev libxml2-dev zip unzip \
    libzip-dev libpq-dev libssl-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip bcmath gd

# Ativar o mod_rewrite do Apache
RUN a2enmod rewrite

# Definir diretório de trabalho
WORKDIR /var/www/html

# Copia o projeto
COPY . .

# Copiar arquivo de config customizado do Apache
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Instalar o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instala dependências PHP
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Dar permissões à storage e bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Rodar as migrations automaticamente (opcional, se o banco já estiver disponível)
# Use try/catch ou `|| true` se quiser evitar falhas no build caso o DB não esteja pronto
RUN php artisan config:cache \
    && php artisan migrate --force || true

# RUN php artisan config:cache && \
    # php artisan migrate --force

# EXPOSE 8000

# Inicia servidor Laravel
# CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
