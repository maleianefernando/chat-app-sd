#!/bin/bash

# Espera o banco estar pronto
until nc -z $DB_HOST 5432; do
  echo "Aguardando banco de dados em $DB_HOST..."
  sleep 2
done

php artisan migrate --force
php artisan config:cache
php artisan cache:clear
php artisan config:clear
php artisan route:cache
exec apache2-foreground
