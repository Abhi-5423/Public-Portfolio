FROM php:8.2-cli-alpine

WORKDIR /app

# Install required PHP extensions
RUN docker-php-ext-install fileinfo pdo pdo_mysql

# Copy application files
COPY . /app

# Configure default environment and directory permissions
RUN if [ ! -f .env ]; then cp .env.example .env; fi \
    && mkdir -p /app/storage/sessions /app/public/uploads/projects \
    && chmod -R 777 /app/storage /app/public/uploads

EXPOSE 8080

# Start PHP built-in server on the port assigned by Render/Railway or default 8080
CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-8080} router.php"]
