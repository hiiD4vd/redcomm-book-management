#!/usr/bin/env bash
# build.sh - Build script for Render (or other platforms)

# Create the database file if it doesn't exist
touch database/database.sqlite

# Install dependencies
composer install --no-interaction --prefer-dist --optimize-autoloader

# Run migrations and seed data
php artisan migrate:fresh --seed --force
