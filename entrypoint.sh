#!/bin/bash

# Espera o banco estar pronto
until nc -z $DB_HOST 5432; do
  echo "Aguardando banco de dados em $DB_HOST..."
  sleep 2
done

RUN php artisan migrate:fresh --force
RUN php artisan config:cache
RUN php artisan cache:clear
RUN php artisan config:clear
RUN php artisan route:cache
exec apache2-foreground
