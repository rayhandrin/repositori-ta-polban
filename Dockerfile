# Start with the official Laravel image
FROM bitnami/laravel:9.5.0

WORKDIR .

COPY . .

# Expose the port the app runs in
EXPOSE 8000
