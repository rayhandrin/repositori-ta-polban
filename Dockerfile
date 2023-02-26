FROM bitnami/laravel:9.5.0

COPY . .

RUN php artisan migrate

CMD ['php', 'artisan', 'serve']
