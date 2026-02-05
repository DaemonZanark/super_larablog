# Larablog

Application de blog développée avec Laravel pour créer, gérer et partager des articles.

## Déploiement
L'application a été déployée via Dockploy / Traefik :
http://naly-larablog-192-168-101-9.traefik.me

## Technologies
- PHP + Laravel
- JavaScript
- Composer
- npm
- Docker / Dockploy (optionnel)

## Prérequis
- PHP 8.0+ (ou version requise par la branche)
- Composer
- Node.js & npm
- MySQL / MariaDB (ou autre base configurée)
- Docker (si vous utilisez la configuration Dockploy)

## Installation (local)
1. Cloner le dépôt :
    - `git clone <url-du-repo>`
2. Se placer dans le dossier du projet :
    - `cd <nom-du-repo>`
3. Installer les dépendances PHP :
    - `composer install`
4. Copier le fichier d'environnement et générer la clé :
    - `cp .env.example .env`
    - `php artisan key:generate`
5. Installer les dépendances JavaScript et compiler les assets :
    - `npm install`
    - `npm run dev` (ou `npm run build` pour la production)
6. Lancer les migrations (et éventuels seeders) :
    - `php artisan migrate --seed`

## Lancer l'application
- Serveur de développement Laravel :
    - `php artisan serve`
- Ou via Docker / Dockploy :
    - suivre la configuration Dockploy présente dans le dépôt (ex : `docker-compose up -d` selon la configuration)

## Tests
- Lancer la suite de tests :
    - `php artisan test` ou `vendor/bin/phpunit`

## Configuration supplémentaire
- Mettre à jour les variables d'environnement dans ` .env ` (base de données, mail, services externes).
- Si vous utilisez Traefik/Dockploy, vérifier les routes et certificats dans la configuration Dockploy.

## Contribuer
- Fork, créez une branche feature/fix, faites une PR avec description et tests si possible.

## Licence
Préciser la licence du projet (ex : MIT).
