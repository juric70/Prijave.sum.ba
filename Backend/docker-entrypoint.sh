#!/bin/bash

# Ensure necessary directories exist
echo "Ensuring storage directories exist..."
mkdir -p /var/www/storage/framework/sessions
mkdir -p /var/www/storage/framework/cache
mkdir -p /var/www/storage/framework/views
mkdir -p /var/www/bootstrap/cache

# Set correct permissions
echo "Setting permissions for storage and bootstrap/cache..."
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Clear and cache configuration as www-data user
echo "Clearing and caching configuration..."
su -s /bin/bash www-data -c "php artisan config:clear"
su -s /bin/bash www-data -c "php artisan config:cache"

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Check and seed the database
echo "Checking and seeding the database..."
php artisan db:check-and-seed

# Generate 

# Start the Laravel application
exec "$@"