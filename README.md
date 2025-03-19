# TomTroc - Plateforme d'échange de livres

Vous voici sur **TomTroc**, une plateforme permettant aux lecteurs d'échanger des livres. Ce projet a été développé en **PHP** avec une architecture **MVC (Modèle-Vue-Contrôleur)** et utilise une base de données MySQL pour stocker les informations des utilisateurs et des livres.

## 📌 Fonctionnalités principales

- Inscription et connexion des utilisateurs
- Ajout, modification et suppression de livres
- Visualisation des livres disponibles pour l'échange
- Consultation des profils des autres utilisateurs
- Système de messagerie intégré pour discuter avec les autres membres
- Gestion des images des livres et des avatars des utilisateurs

## 🛠️ Prérequis

Avant d'installer et d'utiliser ce projet, assurez-vous d'avoir les éléments suivants installés sur votre machine :

- **PHP** (>= 7.4)
- **MySQL** ou MariaDB
- **Apache** (ou un serveur local comme XAMPP, WAMP ou MAMP)
- **Un navigateur web**

## 🚀 Installation

### 1️⃣ Cloner le projet

```sh
  git clone https://github.com/Tamsin-Rouaud/P6-TOMTROC.git
  cd P6-TOMTROC
```

### 2️⃣ Configurer la base de données

1. Créez une base de données MySQL nommée `tomtroc`.
2. Importez le fichier `tomtroc.sql` dans votre base de données.

### 3️⃣ Configuration du projet

1. **Renommez** le fichier `config.exemple.php` en `config.php`.
2. **Modifiez** les informations de connexion à la base de données dans `config.php` en exécutant les instructions de ce fichier.

Voici les identifiants à modifier :

```php
  define('DB_HOST', 'votre_hôte');
  define('DB_NAME', 'nom_de_votre_base');
  define('DB_USER', 'votre_utilisateur');
  define('DB_PASS', 'votre_mot_de_passe');
```

### 4️⃣ Démarrer le serveur local

Si vous utilisez **XAMPP** ou **WAMP**, placez le projet dans le dossier `htdocs` et démarrez Apache et MySQL.

Sinon, vous pouvez utiliser le serveur PHP intégré :

```sh
  php -S localhost:8000
```

Puis ouvrez un navigateur et accédez à `http://localhost:8000` ou `http://localhost/p6-tomtroc/` selon votre configuration.

## 🎯 Utilisation

- Accédez à la page d'accueil et inscrivez-vous
- Ajoutez des livres à votre bibliothèque personnelle
- Parcourez les livres des autres utilisateurs
- Contactez les membres via la messagerie intégrée pour organiser un échange

## 📂 Architecture du projet (MVC)

```
P6-TOMTROC/
│-- config/            # Configuration du projet
│-- controllers/       # Contrôleurs gérant la logique métier
│-- css/               # Fichiers de styles
│-- images/            # Images de base du projet
│-- models/            # Modèles interagissant avec la base de données
│-- services/          # Classes utilitaires (routeur, gestion des images, validations, etc.)
|   |-- Router.php     # Fichier Routeur
|   |-- Utils.php      # Fichier des principales méthodes utilitaires du projet
│-- uploads/           # Images des utilisateurs et des livres
│   │-- books/         # Image des livres téchargés (par un utilisateur)
│   │-- users/         # Image des profils téléchargés (par un utilisateur)
│-- views/             # Templates HTML/PHP pour l'affichage
│   │-- partials/      # Fichiers partagés (header, footer)
│   │-- templates/     # Fichiers partagés (main)
|   |-- View.php       # Fichier Class View principal
│-- index.php          # Point d'entrée principal
│-- menu.js            # JavaScript pour menu burger
│-- README.md          # Documentation
│-- tomtroc.sql        # Fichier sql pour base de données
```


✨ Merci d'utiliser **TomTroc** ! Nous espérons que ce projet facilitera vos échanges de livres ! 📚

