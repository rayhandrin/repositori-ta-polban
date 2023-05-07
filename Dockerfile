# Start with the official Laravel image
FROM bitnami/laravel:9.5.0

# Set working directory
WORKDIR .

# Copy the application code
COPY . .

# Install application dependencies
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Create a development.txt file
RUN echo "This is a development environment." > development.txt

# Expose the port the app runs in
EXPOSE 4000
