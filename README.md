<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Riad - Système de Réservation de Restaurant

![Riad Logo](public/placeholders/plat_placeholder.jpg) 
<!-- Remplace plat_placeholder.jpg par le chemin vers un vrai logo si tu en as un -->

**Riad** est une application web complète développée avec Laravel 11, conçue pour gérer les réservations et le menu d'un restaurant. Elle offre une interface élégante pour les clients et un tableau de bord puissant pour les administrateurs.

---

## Table des Matières

- [Fonctionnalités Clés](#fonctionnalités-clés)
  - [Espace Client](#espace-client)
  - [Espace Administrateur](#espace-administrateur)
- [Technologies Utilisées](#technologies-utilisées)
- [Prérequis](#prérequis)
- [Installation et Configuration](#installation-et-configuration)
- [Identifiants de Test](#identifiants-de-test)
- [Structure des Dossiers Clés](#structure-des-dossiers-clés)


## Fonctionnalités Clés

### Espace Client

- **Consultation du Menu :** Visualisation des plats groupés par catégorie, avec images, descriptions et prix.
- **Recherche de Plats :** Barre de recherche dynamique pour trouver des plats par nom ou ingrédient.
- **Système d'Authentification :** Inscription avec champs personnalisés (nom, prénom, CIN, etc.) et connexion sécurisée via une modale interactive, sans quitter la page principale.
- **Processus de Réservation :**
    1. Le client choisit une date, une heure et le nombre de convives.
    2. Le système affiche les tables **réellement disponibles** pour ce créneau.
    3. Le client sélectionne la table de son choix et envoie une demande.
    4. La réservation est mise en attente de validation par l'administrateur.
- **Espace Personnel (Sidebar) :**
    - **Gestion de Profil :** Mise à jour des informations personnelles.
    - **Mes Réservations :** Suivi du statut des réservations (en attente, confirmée, refusée).
    - **Téléchargement de Billet :** Possibilité de télécharger un billet PDF personnalisé pour les réservations confirmées.
    - **Boîte de Messagerie :** Système de ticketing interne pour envoyer des feedbacks, poser des questions et recevoir des réponses de l'administration.
- **Notifications :** Indicateur visuel (point rouge) pour les nouvelles réponses non lues dans la boîte de messagerie.

### Espace Administrateur

- **Tableau de Bord :** Vue d'ensemble avec des statistiques clés (réservations en attente, clients, etc.) et un accès rapide aux dernières demandes.
- **Gestion des Réservations :**
    - Visualisation de toutes les demandes de réservation.
    - Validation en un clic des tables suggérées par les clients.
    - Possibilité de refuser une demande et d'être redirigé pour envoyer un message d'explication.
- **Gestion du Menu (CRUD complet) :**
    - Ajout, modification et suppression de plats.
    - Upload d'images personnalisées pour chaque plat.
- **Gestion des Tables :** Vue d'ensemble du planning des tables pour n'importe quelle date, affichant les tables libres et celles déjà réservées.
- **Boîte de Messagerie :** Consultation des feedbacks des clients et possibilité d'y répondre directement.

---

## Technologies Utilisées

- **Framework :** Laravel 11
- **Frontend :** HTML5, CSS3, JavaScript (vanilla)
- **Authentification :** Laravel Breeze (personnalisé)
- **Base de Données :** MySQL (configurable dans `.env`)
- **Génération PDF :** `barryvdh/laravel-dompdf`
- **Dépendances :** PHP 8.2+, Composer, Node.js

---

## Prérequis

- PHP >= 8.2
- Composer
- Node.js & npm
- Un serveur de base de données (ex: MySQL, MariaDB)

---

## Installation et Configuration

Suivez ces étapes pour mettre en place le projet sur votre machine locale.

1.  **Cloner le projet (si hébergé sur Git) :**
    ```bash
    git clone https://votre-repository/riad-reservation-system.git
    cd riad-reservation-system
    ```

2.  **Installer les dépendances PHP :**
    ```bash
    composer install
    ```

3.  **Installer les dépendances JavaScript :**
    ```bash
    npm install
    ```

4.  **Configurer l'environnement :**
    - Copiez le fichier d'exemple `.env.example` en `.env` : `cp .env.example .env`
    - Générez la clé d'application :
      ```bash
      php artisan key:generate
      ```
    - Configurez vos informations de base de données dans le fichier `.env` :
      ```env
      DB_CONNECTION=mysql
      DB_HOST=127.0.0.1
      DB_PORT=3306
      DB_DATABASE=riad_db
      DB_USERNAME=root
      DB_PASSWORD=
      ```

5.  **Créer le lien de stockage :**
    Cette commande rend les images uploadées accessibles publiquement.
    ```bash
    php artisan storage:link
    ```

6.  **Lancer les migrations et les seeders :**
    Cette commande va créer toutes les tables et les peupler avec les données initiales (admin, plats, tables).
    ```bash
    php artisan migrate:fresh --seed
    ```

7.  **Lancer les serveurs :**
    - Lancez le serveur de développement Laravel :
      ```bash
      php artisan serve
      ```
    - (Optionnel, si vous utilisez Vite) Dans un autre terminal, lancez le serveur Vite :
      ```bash
      npm run dev
      ```

L'application est maintenant accessible à l'adresse `http://127.0.0.1:8000`.

---

## Identifiants de Test

Après avoir lancé les seeders, vous pouvez utiliser les identifiants suivants pour tester l'application :

-   **Rôle :** Administrateur
-   **Email :** `admin@gmail.com`
-   **Mot de passe :** `admin`

Pour un compte client, vous pouvez en créer un via le formulaire d'inscription.

---

## Structure des Dossiers Clés

-   `app/Http/Controllers/` : Contient la logique métier (séparée en `Admin` et `Client`).
-   `app/Models/` : Contient les modèles Eloquent pour l'interaction avec la base de données.
-   `database/migrations/` : Contient la structure des tables de la base de données.
-   `database/seeders/` : Contient les données initiales pour le développement.
-   `resources/views/` : Contient toutes les vues Blade (séparées en `admin`, `client`, `layouts`, `partials`, etc.).
-   `routes/web.php` : Définit toutes les routes de l'application.
-   `public/css/` : Contient les fichiers CSS personnalisés.
