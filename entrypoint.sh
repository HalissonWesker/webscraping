#!/bin/sh

# Espera até que o MySQL esteja pronto
echo "Aguardando MySQL iniciar..."
until nc -z -v -w30 mysql 3306
do
  echo "Aguardando conexão MySQL..."
  sleep 1
done

echo "MySQL está pronto. Executando migrações..."
php artisan migrate --force

# Inicie o PHP-FPM
php-fpm
