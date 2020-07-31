#!/bin/sh

echo ""
echo "Install dependencies ..."
composer install

echo ""
echo "Waiting for mysql ..."
waitforit -host=mysql -port=3306

echo ""
echo "Running doctrine migrations ..."
bin/console doctrine:migration:migrate --no-interaction

echo ""
echo "Running development server ..."
exec bin/console server:run 0.0.0.0:8000
