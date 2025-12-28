#!/usr/bin/env bash
set -euo pipefail

composer install --no-interaction --prefer-dist

if [ ! -f .env ]; then
  cp .env.example .env
fi

php artisan key:generate --ansi

mkdir -p database
touch database/database.sqlite

php artisan migrate --force
php artisan db:seed --force

php artisan storage:link || true

echo "Demo setup complete."
