#!/bin/bash
set -e

echo "--- 1. Installation de Symfony CLI ---"
curl -sS https://get.symfony.com/cli/installer | bash
ln -sf /root/.symfony5/bin/symfony /usr/local/bin/symfony

echo "--- 2. Installation de pdo_mysql ---"
docker-php-ext-install pdo_mysql

echo "--- 3. Installation et démarrage de MariaDB ---"
apt-get update && apt-get install -y default-mysql-server
mkdir -p /run/mysqld
chown mysql:mysql /run/mysqld
service mariadb start

# Attente que MariaDB soit prêt
until mysqladmin ping >/dev/null 2>&1; do
  echo -n "."
  sleep 1
done
echo " MariaDB est prêt !"

echo "--- 4. Configuration de la base de données ---"
mysql -e "CREATE DATABASE IF NOT EXISTS canispro_bdd;"
mysql -e "CREATE USER IF NOT EXISTS 'canispro'@'localhost' IDENTIFIED BY 'Trasio2026.';"
mysql -e "GRANT ALL ON canispro_bdd.* TO 'canispro'@'localhost'; FLUSH PRIVILEGES;"

echo "--- 5. Installation d'Adminer (Gestionnaire DB) ---"
# Nettoyage de phpMyAdmin si le dossier existe
rm -rf /workspaces/CanisProGroupe-4/.phpmyadmin
# Téléchargement d'Adminer à la racine du projet
wget https://www.adminer.org/latest.php -O /workspaces/CanisProGroupe-4/adminer.php

echo "--- 6. Dépendances Composer et Migrations ---"
composer install --working-dir=/workspaces/CanisProGroupe-4
cd /workspaces/CanisProGroupe-4
php bin/console doctrine:migrations:migrate --no-interaction

echo "--- CONFIGURATION TERMINÉE ! ---"