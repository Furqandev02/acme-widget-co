# Use the official PHP 8.3 CLI image
FROM php:8.3-cli

# Set the working directory
WORKDIR /app

# Install necessary PHP extensions (pdo, pdo_mysql, etc.)
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the project files into the container
COPY . .

# Install Composer dependencies (including dev dependencies)
RUN composer install --optimize-autoloader

# Run Composer dump-autoload to ensure all classes are autoloaded
RUN composer dump-autoload

# Run PHPStan to verify static analysis
RUN ./vendor/bin/phpstan analyse src

# Run PHPUnit tests (if you want to run tests automatically in Docker)
RUN ./vendor/bin/phpunit tests

# Expose port 8080 for the built-in PHP server
EXPOSE 8080

# Command to run the PHP built-in server for serving the app
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]