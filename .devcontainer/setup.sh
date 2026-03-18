#!/bin/bash
set -e

# Symfony CLI
curl -sS https://get.symfony.com/cli/installer | bash
ln -sf /root/.symfony5/bin/symfony /usr/local/bin/symfony

# PHP extension pdo_mysql
docker-php-ext-install pdo_mysql

# MySQL
apt-get update && apt-get install -y default-mysql-server
mariadbd --user=root --skip-networking &
sleep 5
mysql -e "CREATE DATABASE IF NOT EXISTS canispro_bdd;"
mysql -e "CREATE USER IF NOT EXISTS 'canispro'@'localhost' IDENTIFIED BY 'Trasio2026.';"
mysql -e "GRANT ALL ON canispro_bdd.* TO 'canispro'@'localhost'; FLUSH PRIVILEGES;"

# Composer
composer install --working-dir=/workspaces/CanisProGroupe-4

# Migrations
cd /workspaces/CanisProGroupe-4 && php bin/console doctrine:migrations:migrate --no-interaction
