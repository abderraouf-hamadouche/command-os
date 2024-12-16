#!/bin/bash

# Print the user and group the script is running as
# echo "Running as user: $(whoami) (UID: $(id -u))"
# echo "Running with group: $(id -gn)"

# Ensure the script is run as root (ID 0 is root)
if [ "$(id -u)" -ne "0" ]; then
    echo "This script must be run as root" 1>&2
    exit 1
fi

echo "Running as root, proceeding with setup..."

# Set the necessary permissions and ownership for vendor, storage, and cache
echo "Fixing permissions for vendor, storage, and cache directories..."

# Set the correct ownership and permissions for the vendor directory
chown -R www-data:www-data /var/www/html/vendor
chmod -R 775 /var/www/html/vendor

# Fix permissions for storage and cache directories
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache

# Optionally run Composer install (if needed)
composer install --no-dev --optimize-autoloader

# Run Laravel-specific commands
php artisan key:generate
php artisan optimize:clear

echo "Permissions fixed and application setup completed."
# Keep the container running
tail -f /dev/null