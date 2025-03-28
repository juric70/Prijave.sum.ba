FROM php:8.2-cli

# Set environment variables
ENV USING_DOCKER=true

# Install system dependencies
RUN apt-get update && apt-get install -y \
	unzip \
	git \
	&& docker-php-ext-install pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy only composer files first to leverage Docker layer caching
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-scripts --no-dev --optimize-autoloader

# Copy the rest of the application code
COPY . .

# Run composer scripts after copying the application code
RUN composer install

# Copy the entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh

# Make the script executable
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Set the entrypoint
ENTRYPOINT ["docker-entrypoint.sh"]

# Expose the port
EXPOSE 8000

# Start the application
CMD php artisan serve --host=0.0.0.0 --port=8000