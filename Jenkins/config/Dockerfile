# Use the official PHP image as the base image
FROM php:8.2-cli

# Copy the PHP script into the Docker image
COPY config/config.php /config.php

# Set the working directory
WORKDIR /

# Install cURL extension
RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    && docker-php-ext-install curl

RUN chmod +x config.php

# Set the entry point to run the PHP script
CMD ["php", "config.php"]
