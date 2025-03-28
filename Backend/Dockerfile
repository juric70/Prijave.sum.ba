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

# Copy the application code
COPY . .

# Install PHP dependencies
RUN composer install

# Set permissions
RUN chown -R 777 storage bootstrap/cache

# Expose the port
EXPOSE 8000

# Start the application
CMD php artisan migrate --seed && php artisan serve --host=0.0.0.0 --port=8000