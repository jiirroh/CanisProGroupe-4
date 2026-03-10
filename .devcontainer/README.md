# Symfony 8 Development Container

Ce projet utilise un dev container pour garantir que tous les développeurs travaillent avec le même environnement.

## Versions incluses

- **PHP**: 8.4 (avec extensions nécessaires pour Symfony)
- **MySQL**: 8.0
- **Composer**: Dernière version
- **Symfony CLI**: Installée
- **Node.js & npm**: Pour les assets front-end

## Démarrage

1. Ouvrez le projet dans VS Code
2. Quand VS Code vous demande de rouvrir dans un container, cliquez sur "Reopen in Container"
3. Attendez que le container se construise (première fois seulement)

## Services disponibles

- **Application Symfony**: http://localhost:8000
- **Base de données MySQL**: localhost:3306
  - User: `canispro`
  - Password: `canispro123`
  - Database: `canispro_bdd`

## Commandes utiles

```bash
# Démarrer le serveur Symfony
php bin/console serve

# Créer une entité
php bin/console make:entity

# Générer un CRUD
php bin/console make:crud

# Migrations Doctrine
php bin/console doctrine:migrations:migrate

# Vider le cache
php bin/console cache:clear
```

## Extensions VS Code incluses

- PHP Intelephense
- Tailwind CSS IntelliSense
- Prettier
- ESLint
- Docker
- GitHub Copilot

## Structure du projet

```
.devcontainer/
├── devcontainer.json      # Configuration principale
├── docker-compose.yml     # Services (app + database)
└── Dockerfile            # Image PHP personnalisée
```

## Dépannage

Si vous avez des problèmes avec le dev container :

1. Fermez VS Code
2. Supprimez le dossier `.vscode` s'il existe
3. Ouvrez à nouveau VS Code et rouvrez le projet
4. Choisissez "Reopen in Container"

Pour reconstruire complètement le container :
```bash
# Dans VS Code : Ctrl+Shift+P > "Dev Containers: Rebuild Container"
```