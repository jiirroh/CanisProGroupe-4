FROM mcr.microsoft.com/devcontainers/php:1-8.4-bookworm

# Correction de l'erreur GPG Yarn et installation des dépendances
RUN rm -f /etc/apt/sources.list.d/yarn.list \
    && apt-get update && export DEBIAN_FRONTEND=noninteractive \
    && apt-get install -y libicu-dev libzip-dev \
    && docker-php-ext-install intl zip pdo_mysql

# Installation de Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony