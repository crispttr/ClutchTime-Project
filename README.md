# Projet : Fiction Interactive Multi-Plateforme (Laravel + Vue.js) 🌟

## Introduction 📚

Ce projet consiste à développer une application web complète sous forme de fiction interactive multi-plateforme utilisant Laravel pour le backend et Vue.js pour le frontend. L'objectif est de créer une histoire à choix multiples où les décisions de l'utilisateur influencent le déroulement du récit.

## Choix du projet Basket 🏀

Le choix d'un projet Basket pour cette application permet d'illustrer l'importance des décisions stratégiques dans le déroulement d'une histoire interactive. À travers une narration dynamique et des choix multiples, l'utilisateur peut incarner un joueur de basketball et faire des choix qui influencent sa carrière sportive, ses relations avec l'équipe et son évolution personnelle.

## Objectifs pédagogiques 🎯

* Développer une application web complète de type SPA (Single Page Application).
* Implémenter un backend structuré avec Laravel et des routes RESTful.
* Créer une API versionnée avec validation, middleware, et relations Eloquent.
* Gérer un frontend en Vue.js pour naviguer dans une histoire interactive.
* Intégrer le backend et le frontend via des requêtes API (GET, POST, etc.).

## Technologies utilisées 💻

* Backend : Laravel 10.x
* Frontend : Vue.js 3.x
* Base de données : MySQL / PostgreSQL / SQLite
* API : RESTful versionnée
* Authentification : Laravel Sanctum
* Contrôle de version : Git (GitHub)

## Installation et configuration 🛠️

### Prérequis ✅

* PHP >= 8.1
* Composer
* Node.js & npm
* Serveur web (Apache, Nginx)
* Base de données MySQL, PostgreSQL ou SQLite

### Backend 🚀

1. Cloner le dépôt :

   ```bash
   git clone https://github.com/crispttr/clutchtime-project.git
   cd clutchtime-project/backend-clutchtime
   ```
2. Installer les dépendances Laravel :

   ```bash
   composer install
   ```
3. Copier le fichier d'exemple d'environnement :

   ```bash
   cp .env.example .env
   ```
4. Générer la clé d'application :

   ```bash
   php artisan key:generate
   ```
5. Configurer la base de données dans le fichier `.env` :

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=fiction_db
   DB_USERNAME=root
   DB_PASSWORD=secret
   ```
6. Exécuter les migrations :

   ```bash
   php artisan migrate
   ```
7. Lancer le serveur de développement :

   ```bash
   php artisan serve
   ```

### Frontend 🌐

1. Accéder au répertoire frontend :

   ```bash
   cd ../frontend-clutchtime
   ```
2. Installer les dépendances :

   ```bash
   npm install
   ```
3. Démarrer l'application :

   ```bash
   npm run dev
   ```

## Utilisation 🚦

* Accéder à l'application via :

  * Backend : `http://localhost:8000`
  * Frontend : `http://localhost:5173`
* Créer un compte ou se connecter.
* Naviguer dans l'histoire et faire des choix pour progresser.

## Fonctionnalités principales 🌈

* Création et gestion des histoires, chapitres et choix.
* Authentification avec Laravel Sanctum.
* Navigation dynamique entre les chapitres.
* Sauvegarde et reprise de la progression.
* Interface responsive.

## Tests 🧪

* Lancer les tests PHPUnit :

  ```bash
  php artisan test
  ```
* Tester l'API avec Postman ou Insomnia pour valider les réponses.

## Déploiement 🌍

1. Construire le frontend pour la production :

   ```bash
   npm run build
   ```
2. Configurer le serveur web pour pointer vers `public` pour Laravel et le dossier de build pour Vue.js.

## Contribuer 🤝

* Forker le projet.
* Créer une branche avec un nom explicite :

  ```bash
  git checkout -b feature/nouvelle-fonctionnalite
  ```
* Soumettre une pull request.

## Licence 📜

Ce projet est sous licence MIT. Voir le fichier LICENSE pour plus d'informations.

## Auteur ✨

* Cristian Pottier - Étudiant HEIG-VD - Classe 52/2

Pour toute question, contactez-moi via l'issue tracker ou par email.
