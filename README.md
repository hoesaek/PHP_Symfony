# Projet d'apprentissage de Symfony par le bias de Site E-commerce en PHP/Symfony

Ce document est le fichier README pour le projet de site e-commerce actuellement en cours de réalisation. 
Il fournit une vue d'ensemble des fonctionnalités principales, des concepts clés utilisés dans le projet, 
ainsi que des commandes et pratiques à suivre pour contribuer au développement.

---

## Table des Matières

1. [Prérequis](#prérequis)
2. [Installation](#installation)
3. [Structure du Projet](#structure-du-projet)
4. [Fonctionnalités Implémentées](#fonctionnalités-implémentées)
5. [Utilisation des Commandes Symfony](#utilisation-des-commandes-symfony)
6. [Concepts Clés](#concepts-clés)

---

## Prérequis

- PHP >= 8.1
- Composer
- Symfony CLI
- Serveur web (Apache ou Nginx)
- Base de données MySQL ou PostgreSQL

## Installation

1. Clonez le dépôt :
   ```bash
   git clone https://github.com/hoesaek/PHP_Symfony.git
   cd PHP_Symfony
   ```
2. Installez les dépendances avec Composer :
   ```bash
   composer install
   ```
3. Configurez le fichier `.env` avec les informations de votre base de données :
   ```dotenv
   DATABASE_URL="mysql://php:8c!3h)|a>al6@127.0.0.1:3306/restoretech?serverVersion=8.0.32&charset=utf8mb4"
   ```
4. Créez la base de données et exécutez les migrations :
   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```
5. Démarrez le serveur Symfony :
   ```bash
   symfony server:start // {symfony serve} fonctionne aussi
   ```

## Structure du Projet

Le projet suit une structure standard Symfony :

- `src/Controller/` : Contient les contrôleurs qui gèrent les routes et la logique d'application.
- `src/Entity/` : Contient les entités Doctrine qui représentent les tables de la base de données.
- `templates/` : Contient les fichiers de vue Twig.
- `config/` : Fichiers de configuration de Symfony.
- `public/` : Contient les ressources publiques (CSS, JS, images).

## Fonctionnalités Implémentées

1. **Gestion des utilisateurs** : Inscription, connexion, et gestion des rôles.
2. **Catalogue de produits** : CRUD complet des produits avec l'utilisation de slugs pour les URL.
3. **Panier et commande** : Ajout au panier et gestion des commandes (en cours de développement).
4. **Administration** : Gestion des entités principales via une interface d'administration.

## Utilisation des Commandes Symfony

### Créer une entité avec Doctrine
```bash
php bin/console make:entity
```
Après avoir créé l'entité, lancez les migrations :
```bash
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

### Créer un contrôleur
```bash
php bin/console make:controller NomDuControleur
```

### Créer une vue Twig
Les fichiers Twig sont généralement créés dans le répertoire `templates/`. Vous pouvez utiliser les outils de votre IDE pour faciliter leur création.

### Générer des Slugs
Un slug est une URL "amicale" pour les produits.
Exemple de l'utilisation d'un slug "id" afin d'ajouter au panier l'element lier à l'identifiant du produit
```php
    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function add($id, Cart $cart, ProductRepository $productRepository, Request $request): Response
    {
        $produit = $productRepository->findOneById($id);

        $cart->add($produit);

        return $this->redirect($request->headers->get('referer'));
    }
```

## Concepts Clés

### Modèle-Vue-Contrôleur (MVC)
- **Modèle** : Gère les données (Entités et Repositories).
- **Vue** : Représente les données à l'utilisateur (fichiers Twig).
- **Contrôleur** : Traite les requêtes et renvoie les réponses (classes dans `src/Controller/`).

### Injection de dépendances
Symfony utilise l'injection de dépendances pour gérer les services. 
Cela permet d'éviter de devoir instancier manuellement un objet pour rendre le code plus flexible.
Par exemple, pour injecter le service `ProductRepository` :
```php
   #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function add($id, Cart $cart, ProductRepository $productRepository, Request $request): Response
    {
        $produit = $productRepository->findOneById($id);

        $cart->add($produit);

        return $this->redirect($request->headers->get('referer'));
    }
```

### Routes
Les routes sont configurées dans les contrôleurs ou dans les fichiers YAML :
```php
    #[Route('/cart/decrease/{id}', name: 'app_cart_decrease')]
    public function decrease($id, Cart $cart): Response
    {
        $cart->decrease($id);
        return $this->redirectToRoute('app_cart');
    }
```

### Utilisation de Twig
Twig est le moteur de template pour générer des vues dynamiques. 
Exemple pour la vue d'une modification de mots de passe:
```twig
{% extends 'base.html.twig' %}

{% block body %}

<div class="container mt-4">
    <h1 class="mb-3">Mon Espace Perso</h1>
    <div class="row">
        <div class="col-md-4">
            {% include 'account/_menu.html.twig' %}
        </div>
        <div class="col-md-8">
            <h3>Modification de mon mot de passe</h3>
            {{ form(modifyPwd) }}
        </div>            
    </div>
</div>
{% endblock %}
```
