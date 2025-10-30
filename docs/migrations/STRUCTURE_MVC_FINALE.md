# 📁 Structure MVC Finale - Digita Marketing

## ✅ Projet Nettoyé et Organisé

Date : 25 Octobre 2025
Version : 2.1.0

---

## 🎯 Architecture MVC

Le projet suit une architecture MVC (Model-View-Controller) moderne et organisée.

### 📂 Structure des Dossiers

```
digita-marketing/
├── app/                          # Application MVC
│   ├── Controllers/              # Contrôleurs
│   │   └── AdminController.php   # Gestion admin (dashboard, contacts, newsletters, webhooks, campaigns)
│   ├── Models/                   # Modèles
│   │   ├── Contact.php          # Modèle Contact
│   │   ├── Newsletter.php       # Modèle Newsletter
│   │   └── User.php             # Modèle User
│   ├── Views/                    # Vues
│   │   ├── admin/               # Vues admin
│   │   │   ├── campaigns.php   # Page campagnes marketing
│   │   │   ├── contacts.php    # Page messages de contact
│   │   │   ├── dashboard.php   # Dashboard principal
│   │   │   ├── newsletters.php # Page abonnés newsletter
│   │   │   └── webhooks.php    # Page configuration webhooks
│   │   ├── layouts/             # Layouts
│   │   │   └── admin.php       # Layout admin
│   │   └── partials/            # Composants réutilisables
│   │       └── stat-card.php   # Carte de statistique
│   ├── Helpers/                 # Classes utilitaires
│   │   ├── DateHelper.php      # Gestion des dates
│   │   └── StringHelper.php    # Manipulation de chaînes
│   ├── Middleware/              # Middleware
│   │   └── AuthMiddleware.php  # Vérification authentification
│   └── Services/                # Services métier
│       ├── EmailService.php    # Envoi d'emails
│       └── ValidationService.php # Validation de données
│
├── config/                       # Configuration
│   ├── app.php                  # Configuration application
│   ├── config.php               # Configuration générale
│   └── database.php             # Configuration base de données
│
├── database/                     # Scripts base de données
│   ├── digita.sql               # Structure complète
│   └── init.sql                 # Initialisation
│
├── includes/                     # Fichiers inclus (ancienne structure - à migrer)
│   ├── partials/                # Composants partiels
│   │   ├── header.php           # En-tête
│   │   ├── navbar.php           # Navigation
│   │   ├── sidebar-agence.php   # Sidebar droite avec gestion utilisateur
│   │   └── sidebar-onglet.php   # Sidebar onglets services
│   ├── auth.php                 # Fonctions authentification
│   ├── Cache.php                # Gestion du cache
│   ├── Database.php             # Connexion base de données
│   └── Router.php               # Routeur
│
├── public/                       # Dossier public (point d'entrée)
│   ├── admin/                   # Anciens fichiers admin (à supprimer)
│   ├── assets/                  # Assets publics
│   │   ├── css/                 # Feuilles de style
│   │   ├── images/              # Images
│   │   └── js/                  # Scripts JavaScript
│   ├── .htaccess                # Configuration Apache
│   └── index.php                # Point d'entrée principal ✅
│
├── templates/                    # Templates de pages
│   ├── home.php                 # Page d'accueil
│   ├── about.php                # Page à propos
│   ├── blog.php                 # Page blog
│   ├── boutique.php             # Page boutique
│   └── ...
│
├── tests/                        # Tests unitaires et d'intégration
│   ├── Integration/
│   └── Unit/
│
├── .env                          # Variables d'environnement
├── .htaccess                     # Configuration Apache racine
├── composer.json                 # Dépendances PHP
├── connexion.php                 # Page de connexion ✅
└── inscription.php               # Page d'inscription ✅
```

---

## 🔄 Flux de Requête

### 1. Point d'Entrée
```
Requête → public/.htaccess → public/index.php
```

### 2. Routage
```php
public/index.php
├── Démarre la session
├── Charge le routeur
└── Route vers le bon contrôleur/template
```

### 3. Contrôleur (MVC)
```php
app/Controllers/AdminController.php
├── Reçoit la requête
├── Appelle les modèles
├── Prépare les données
└── Charge la vue
```

### 4. Modèle (MVC)
```php
app/Models/Contact.php
├── Interagit avec la base de données
├── Valide les données
└── Retourne les résultats
```

### 5. Vue (MVC)
```php
app/Views/admin/dashboard.php
├── Reçoit les données du contrôleur
├── Affiche le HTML
└── Utilise le layout admin
```

---

## 🎨 Pages Disponibles

### Pages Publiques
- **/** - Page d'accueil
- **/a-propos** - À propos
- **/services** - Services
- **/contact** - Contact
- **/blog** - Blog
- **/boutique** - Boutique
- **/connexion** - Connexion ✅
- **/inscription** - Inscription ✅

### Pages Admin (Authentification requise)
- **/admin/dashboard** - Dashboard principal ✅
- **/admin/contacts** - Messages de contact ✅
- **/admin/newsletters** - Abonnés newsletter ✅
- **/admin/webhooks** - Configuration webhooks ✅
- **/admin/campaigns** - Campagnes marketing ✅
- **/admin/logout** - Déconnexion ✅

---

## 🔐 Gestion des Sessions

### Configuration
```php
// public/index.php (ligne 2-8)
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_path', '/');
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_strict_mode', 1);
    session_start();
}
```

### Variables de Session
```php
$_SESSION['user_id']      // ID de l'utilisateur
$_SESSION['user_email']   // Email de l'utilisateur
$_SESSION['user_role']    // Rôle (admin, user)
$_SESSION['user_name']    // Nom de l'utilisateur
```

### Vérification de Connexion
```php
// includes/auth.php
function isUserLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}
```

---

## 🎯 Fonctionnalités Principales

### 1. Dashboard Admin
- ✅ Statistiques en temps réel
- ✅ Actions rapides
- ✅ Activité récente
- ✅ Tâches à faire
- ✅ Aperçu calendrier

### 2. Gestion des Contacts
- ✅ Liste des messages
- ✅ Filtres (tous, non lus, répondus)
- ✅ Marquer comme lu
- ✅ Marquer comme répondu
- ✅ Suppression

### 3. Gestion des Newsletters
- ✅ Liste des abonnés
- ✅ Statistiques
- ✅ Export CSV
- ✅ Filtres par date

### 4. Webhooks
- ✅ Configuration de 3 types de webhooks
- ✅ Activation/désactivation
- ✅ Tests de webhooks
- ✅ Documentation intégrée

### 5. Campagnes Marketing
- ✅ Liste des campagnes
- ✅ Statistiques détaillées
- ✅ Filtres par statut
- ✅ Templates prêts à l'emploi

### 6. Sidebar Utilisateur
- ✅ Affichage conditionnel selon connexion
- ✅ Boutons Connexion/Inscription (non connecté)
- ✅ Encadré utilisateur + Dashboard/Déconnexion (connecté)
- ✅ Badge Admin pour les administrateurs

---

## 🛠️ Technologies Utilisées

### Backend
- **PHP 8.x** - Langage serveur
- **MySQL** - Base de données
- **PDO** - Accès base de données
- **Sessions PHP** - Gestion authentification

### Frontend
- **Bootstrap 5.3** - Framework CSS
- **Bootstrap Icons** - Icônes
- **JavaScript Vanilla** - Interactions
- **AOS** - Animations au scroll

### Architecture
- **MVC** - Modèle-Vue-Contrôleur
- **Router personnalisé** - Gestion des routes
- **Middleware** - Authentification
- **Services** - Logique métier
- **Helpers** - Fonctions utilitaires

---

## 📊 Base de Données

### Tables Principales
```sql
users           -- Utilisateurs
contacts        -- Messages de contact
newsletter      -- Abonnés newsletter
```

### Tables À Créer (TODO)
```sql
webhooks        -- Configuration webhooks
webhook_logs    -- Logs webhooks
campaigns       -- Campagnes marketing
```

---

## 🔧 Configuration

### Variables d'Environnement (.env)
```env
DB_HOST=localhost
DB_NAME=digita_marketing
DB_USER=root
DB_PASS=

SITE_URL=
ENVIRONMENT=development
```

### Configuration Apache
```apache
# .htaccess racine
RewriteEngine On
RewriteBase /
RewriteRule ^ index.php [QSA,L]

# public/.htaccess
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

---

## 🚀 Déploiement

### Prérequis
- PHP 8.0+
- MySQL 5.7+
- Apache avec mod_rewrite
- Composer (optionnel)

### Installation
1. Cloner le projet
2. Configurer `.env`
3. Importer `database/digita.sql`
4. Configurer Apache (DocumentRoot vers `/public`)
5. Accéder au site

### Compte Admin par Défaut
```
Email: admin@digita.com
Mot de passe: admin123
```

---

## 📝 Fichiers Supprimés (Nettoyage)

### Fichiers de Debug
- ❌ `debug_login.php`
- ❌ `test_mvc.php`
- ❌ `list_users.php`
- ❌ `check_data.php`

### Doublons
- ❌ `index.php` (racine - ancien)
- ❌ `config.php` (racine - doublon)
- ❌ `database.sql` (racine - doublon)
- ❌ `sidebar-ongletbakit.css` (racine - ancien)

### Fichiers Conservés
- ✅ `public/index.php` - Point d'entrée principal
- ✅ `config/config.php` - Configuration
- ✅ `connexion.php` - Page de connexion
- ✅ `inscription.php` - Page d'inscription

---

## 📚 Documentation

### Fichiers de Documentation
- `README.md` - Introduction générale
- `ARCHITECTURE_MVC.md` - Architecture détaillée
- `FEATURES.md` - Fonctionnalités
- `CHANGELOG.md` - Historique des modifications
- `STRUCTURE_MVC_FINALE.md` - Ce fichier ✅

### Documentation Technique
- `PROJECT_STRUCTURE.txt` - Structure du projet
- `INDEX_DOCUMENTATION.md` - Documentation index.php
- `QUICK_START.md` - Démarrage rapide

---

## ✅ Checklist de Vérification MVC

### Structure
- ✅ Dossier `app/` avec Controllers, Models, Views
- ✅ Séparation claire des responsabilités
- ✅ Pas de logique métier dans les vues
- ✅ Pas de HTML dans les contrôleurs

### Contrôleurs
- ✅ `AdminController.php` - Gestion complète admin
- ✅ Méthodes pour chaque action
- ✅ Utilisation des modèles
- ✅ Chargement des vues avec données

### Modèles
- ✅ `Contact.php` - CRUD contacts
- ✅ `Newsletter.php` - CRUD newsletters
- ✅ `User.php` - CRUD utilisateurs
- ✅ Validation des données
- ✅ Interaction avec la base de données

### Vues
- ✅ Templates dans `app/Views/`
- ✅ Layout admin réutilisable
- ✅ Composants partiels (stat-card)
- ✅ Pas de logique PHP complexe

### Services & Helpers
- ✅ `EmailService.php` - Envoi d'emails
- ✅ `ValidationService.php` - Validation
- ✅ `DateHelper.php` - Gestion dates
- ✅ `StringHelper.php` - Manipulation chaînes

### Middleware
- ✅ `AuthMiddleware.php` - Vérification authentification
- ✅ Protection des routes admin

---

## 🎯 Prochaines Étapes (TODO)

### Fonctionnalités
- [ ] Implémenter l'envoi réel des webhooks
- [ ] Créer les tables `webhooks` et `campaigns` en BDD
- [ ] Système d'envoi de campagnes emails
- [ ] Tracking des ouvertures et clics
- [ ] Formulaire de création de campagne
- [ ] Éditeur WYSIWYG pour emails

### Technique
- [ ] Migrer tous les fichiers `includes/` vers MVC
- [ ] Supprimer `public/admin/` (anciens fichiers)
- [ ] Tests unitaires complets
- [ ] Tests d'intégration
- [ ] Documentation API

### Sécurité
- [ ] Validation CSRF
- [ ] Rate limiting
- [ ] Logs de sécurité
- [ ] Chiffrement des données sensibles

---

## 📞 Support

Pour toute question ou problème :
- Email : contact@digita-marketing.com
- Documentation : `/docs`
- Issues : GitHub

---

© 2025 Digita Marketing - Structure MVC v2.1.0
Dernière mise à jour : 25 Octobre 2025
