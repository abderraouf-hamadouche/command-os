FROM php:8.2-fpm

# Arguments defined in docker-compose.yml
ARG user=groot
ARG uid=1001

# Install system dependencies and sudo
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    sudo \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www/html

# Add sudoers file for the created user
RUN echo "$user ALL=(ALL) NOPASSWD:ALL" > /etc/sudoers.d/$user

# Copy the initialization script into the container
COPY init.sh /init.sh

# Make the script executable
RUN chmod +x /init.sh

# Set the entrypoint to run the init.sh with sudo
# ENTRYPOINT ["sudo", "/init.sh"]

# Switch back to non-root user if needed
USER $user

CMD ["php-fpm"]