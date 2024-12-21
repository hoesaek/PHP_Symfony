### Tables principales

#### **1. Utilisateurs (`users`)**
Pour stocker les informations des clients (acheteurs ou demandeurs de réparation) et des administrateurs.
- `id` (INT, clé primaire, auto-incrémentée)
- `nom` (VARCHAR(100))
- `prenom` (VARCHAR(100))
- `email` (VARCHAR(150), unique)
- `mot_de_passe` (VARCHAR(255))
- `adresse` (TEXT)
- `telephone` (VARCHAR(20))
- `role` (ENUM('client', 'admin')) – pour différencier les droits d'accès

---

#### **2. Produits (`products`)**
Pour gérer les produits disponibles à la vente.
- `id` (INT, clé primaire, auto-incrémentée)
- `nom` (VARCHAR(255))
- `description` (TEXT)
- `prix` (DECIMAL(10, 2))
- `stock` (INT)
- `categorie_id` (INT, clé étrangère vers `categories`)
- `image_url` (VARCHAR(255)) – pour les images des produits
- `date_ajout` (DATETIME)

---

#### **3. Catégories de produits (`categories`)**
Pour organiser les produits par type.
- `id` (INT, clé primaire, auto-incrémentée)
- `nom` (VARCHAR(100))
- `description` (TEXT)

---

#### **4. Commandes (`orders`)**
Pour enregistrer les achats des clients.
- `id` (INT, clé primaire, auto-incrémentée)
- `user_id` (INT, clé étrangère vers `users`)
- `date_commande` (DATETIME)
- `statut` (ENUM('en attente', 'en cours', 'livré', 'annulé'))
- `total` (DECIMAL(10, 2))

---

#### **5. Détails des commandes (`order_items`)**
Pour associer des produits spécifiques à une commande.
- `id` (INT, clé primaire, auto-incrémentée)
- `order_id` (INT, clé étrangère vers `orders`)
- `product_id` (INT, clé étrangère vers `products`)
- `quantite` (INT)
- `prix_unitaire` (DECIMAL(10, 2))

---

#### **6. Services de réparation (`repair_services`)**
Pour décrire les types de services de réparation proposés.
- `id` (INT, clé primaire, auto-incrémentée)
- `nom` (VARCHAR(255))
- `description` (TEXT)
- `prix` (DECIMAL(10, 2)) – optionnel si le prix est forfaitaire
- `duree_estimee` (VARCHAR(50)) – par exemple, "2 heures" ou "1 jour"

---

#### **7. Demandes de réparation (`repair_requests`)**
Pour gérer les demandes de réparation des clients.
- `id` (INT, clé primaire, auto-incrémentée)
- `user_id` (INT, clé étrangère vers `users`)
- `service_id` (INT, clé étrangère vers `repair_services`)
- `description_probleme` (TEXT)
- `statut` (ENUM('en attente', 'en cours', 'terminé', 'annulé'))
- `date_demande` (DATETIME)
- `date_reparation` (DATETIME, NULLABLE) – si une date est fixée pour la réparation
- `prix_final` (DECIMAL(10, 2), NULLABLE)

---

#### **8. Techniciens (`technicians`)**
Pour enregistrer les techniciens responsables des réparations.
- `id` (INT, clé primaire, auto-incrémentée)
- `nom` (VARCHAR(100))
- `prenom` (VARCHAR(100))
- `specialite` (VARCHAR(255))
- `telephone` (VARCHAR(20))
- `email` (VARCHAR(150))

---

#### **9. Affectation des réparations (`repair_assignments`)**
Pour associer un technicien à une demande de réparation.
- `id` (INT, clé primaire, auto-incrémentée)
- `repair_request_id` (INT, clé étrangère vers `repair_requests`)
- `technician_id` (INT, clé étrangère vers `technicians`)
- `date_affectation` (DATETIME)

---

### Relations entre les tables

1. **Vente de produits :**
   - `products` est relié à `categories` via `categorie_id`.
   - `orders` est relié à `users` via `user_id`.
   - `order_items` associe `products` et `orders`.

2. **Services de réparation :**
   - `repair_requests` est relié à `users` (client ayant fait la demande) et à `repair_services` (type de service demandé).
   - `repair_assignments` relie `repair_requests` à `technicians`.

3. **Liens globaux :**
   - `users` est le point central, relié à la fois aux commandes (`orders`) et aux demandes de réparation (`repair_requests`).
