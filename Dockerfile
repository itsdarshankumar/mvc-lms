FROM php:latest

WORKDIR /app

COPY . /app

# Install dependencies

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    curl

RUN echo "error_reporting = E_ALL & ~E_WARNING" >> /usr/local/etc/php/php.ini

RUN curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install

RUN composer dump-autoload

# Expose port 8000 and start php server
EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
