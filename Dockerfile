# Image officielle PHP 8.4
FROM php:8.4-cli

# Installation des outils système nécessaires
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Installation des extensions PHP pour Symfony et MySQL
RUN docker-php-ext-install intl zip pdo_mysql opcache

# Installation de la Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash && \
    mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

WORKDIR /var/www/html