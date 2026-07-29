#!/usr/bin/env bash

set -e

# Ensure storage directories are writable
chmod -R 775 storage bootstrap/cache

# Create symlink for public storage (if not exists)
php artisan storage:link --force 2>/dev/null || true

# Ensure SQLite database exists and run migrations
touch database/database.sqlite
php artisan migrate --force 2>/dev/null || true

# Regenerate sitemap with production URL
php artisan sitemap:generate 2>/dev/null || true

# Warmup cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start PHP-FPM
exec php artisan serve --host=0.0.0.0 --port="${PORT:-8000}"
