FROM php:8.2-cli
COPY config/config.php /config.php
WORKDIR /
RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    && docker-php-ext-install curl
RUN chmod +x config.php
CMD ["php", "config.php"]
