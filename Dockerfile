# Start with the official Laravel image
FROM bitnami/laravel:9.5.0

# Set the working directory
WORKDIR /var/www/html

# Copy the application code
COPY . /var/www/html

# Install dependencies
RUN composer install --no-interaction --no-dev --prefer-dist

# Run database migrations
RUN php artisan migrate

# Expose the port the app runs in
EXPOSE 80
