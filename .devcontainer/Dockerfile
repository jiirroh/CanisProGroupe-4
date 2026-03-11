# On impose la version 8.4 de PHP (basée sur Debian Bookworm)
FROM mcr.microsoft.com/devcontainers/php:1-8.4-bookworm

# On installe les outils MySQL et surtout l'extension pdo_mysql pour PHP
RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
    && apt-get install -y default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql

# (Optionnel) Nettoyage pour garder un conteneur léger
RUN apt-get clean -y && rm -rf /var/lib/apt/lists/*