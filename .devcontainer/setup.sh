cat > .devcontainer/setup.sh << 'EOF'
#!/bin/bash
set -e

# Symfony CLI
curl -sS https://get.symfony.com/cli/installer | bash
echo 'export PATH="$HOME/.symfony5/bin:$PATH"' >> /root/.bashrc
echo 'export PATH="$HOME/.symfony5/bin:$PATH"' >> /root/.profile
ln -sf /root/.symfony5/bin/symfony /usr/local/bin/symfony

# MySQL
apt-get update && apt-get install -y default-mysql-server
service mysql start
mysql -e "CREATE DATABASE IF NOT EXISTS canispro_bdd; CREATE USER IF NOT EXISTS 'canispro'@'localhost' IDENTIFIED BY 'Trasio2026.'; GRANT ALL ON canispro_bdd.* TO 'canispro'@'localhost';"

# PHP extensions
docker-php-ext-install pdo_mysql

# Composer
composer install --working-dir=/workspaces/CanisProGroupe-4

# Migrations
cd /workspaces/CanisProGroupe-4 && php bin/console doctrine:migrations:migrate --no-interaction
EOF
chmod +x .devcontainer/setup.sh