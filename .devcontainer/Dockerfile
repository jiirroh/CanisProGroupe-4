# On impose la version 8.4 de PHP (basée sur Debian Bookworm)
FROM mcr.microsoft.com/devcontainers/php:1-8.4-bookworm

# CORRECTION DU BUG YARN : On supprime le dépôt dont la clé est expirée
RUN rm -f /etc/apt/sources.list.d/yarn.list

# On installe les outils MySQL et l'extension pdo_mysql pour PHP
RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
    && apt-get install -y default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql

# Nettoyage pour garder un conteneur léger
RUN apt-get clean -y && rm -rf /var/lib/apt/lists/*