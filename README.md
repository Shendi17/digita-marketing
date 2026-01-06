# 🚀 Digita Marketing - Plateforme Digitale Complète

Plateforme web complète pour l'agence Digita Marketing, offrant des services de marketing digital, formations en ligne, blog professionnel et boutique e-commerce.

## ✨ Fonctionnalités Principales

### 🎓 Formations en Ligne
- 382 formations professionnelles
- Système d'inscription et de progression
- Catégories multiples (SEO, Social Media, Design, etc.)
- Interface d'apprentissage interactive

### 📝 Blog Professionnel
- 382 articles liés aux formations
- Système de catégories et tags
- Recherche avancée
- Sidebar dynamique avec filtres

### 🛍️ Boutique E-commerce
- Catalogue de produits digitaux
- Système de panier
- Gestion des commandes

### 📊 Dashboard Admin
- Gestion des formations et articles
- Statistiques et analytics
- Gestion des utilisateurs
- Campagnes email marketing

### 🎨 Design & UX
- Interface moderne et responsive
- Architecture MVC complète
- 0 styles inline (100% CSS classes)
- Optimisé pour tous les devices

## 📦 Installation

### Prérequis

- PHP 8.2+
- MySQL 8.0+
- Apache/Nginx (mod_rewrite)
- Composer

### Installation Rapide

```powershell
# 1. Configurer .env
# Éditer .env et changer DB_HOST=localhost

# 2. Importer base de données
.\scripts\setup\import-database.ps1

# 3. Tester
php scripts\setup\test-system.php

# 4. Configurer CRON (optionnel)
.\scripts\setup\setup-cron-windows.ps1
```

**Documentation complète:** `INSTALLATION.md`

## 🔧 Installation

1. Cloner le repository :
```bash
git clone [URL_DU_REPO]
cd digita-marketing
```

2. Installer les dépendances :
```bash
./install_dependencies.bat
```

3. Configurer la base de données :
```bash
./setup_database.bat
```

4. Configurer l'environnement :
```bash
./setup_environment.bat
```

## 🏃‍♂️ Démarrage

1. Accéder à l'application :
```
http://digita-marketing.local/
```

2. Pages principales :
- **Accueil** : `/`
- **Blog** : `/blog`
- **Formations** : `/formations`
- **Services** : `/services`
- **Dashboard Admin** : `/admin/dashboard`

3. Connexion admin :
- Email : admin@digita.fr
- Mot de passe : Admin123!

## 🧪 Tests

Exécuter les tests :
```bash
./run_tests.bat
```

## 📚 Documentation API

La documentation de l'API est disponible à :
```
http://digita.local/api-docs/ui.php
```

## 🔄 Pipeline CI/CD

Le projet utilise GitHub Actions pour :
- Tests automatiques
- Vérification du style de code
- Déploiement automatique

## 🛠️ Maintenance

La maintenance automatique s'exécute quotidiennement à 2h du matin pour :
- Nettoyer les anciennes tâches
- Agréger les statistiques
- Optimiser la base de données

## 👥 Contribution

1. Fork le projet
2. Créer une branche (`git checkout -b feature/AmazingFeature`)
3. Commit les changements (`git commit -m 'Add some AmazingFeature'`)
4. Push la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

## 📝 License

Copyright © 2025 Digita. Tous droits réservés.

## 🗂️ Structure du Projet

```
digita-marketing/
├── app/
│   ├── Controllers/        # Contrôleurs MVC
│   ├── Models/            # Modèles de données
│   └── Views/             # Vues (blog, formations, admin, etc.)
│
├── public/
│   ├── assets/
│   │   ├── css/          # Fichiers CSS (hero-unified, global-layout, etc.)
│   │   ├── js/           # JavaScript
│   │   └── images/       # Images et médias
│   └── index.php         # Point d'entrée
│
├── includes/
│   ├── Database.php      # Classe de connexion BDD
│   ├── ViewHelper.php    # Helper pour les vues
│   └── partials/         # Fragments réutilisables (navbar, footer)
│
├── config/
│   └── database.php      # Configuration BDD
│
├── database/
│   ├── migrations/       # Scripts de migration
│   └── seeds/           # Données de test
│
├── docs/                 # 📚 Documentation
│   ├── audits/          # Audits (MVC, Responsive, CSS)
│   ├── guides/          # Guides d'utilisation
│   ├── migrations/      # Historique migrations
│   └── corrections/     # Historique corrections
│
└── tests/               # Tests unitaires
```

## 🔒 Sécurité

- Les fichiers sensibles (`.env`, scripts d'init, etc.) doivent rester hors du dossier `public/`.
- Supprimez ou protégez les scripts d'initialisation (`create_admin.php`, `init_db.php`, etc.) après usage.
- Ne laissez jamais de fichiers comme `phpinfo.php` ou des tests dans l'environnement de production.
- Utilisez `.gitignore` pour éviter de versionner les fichiers de configuration sensibles.

## 🎯 Optimisations Appliquées

### Architecture
- ✅ **MVC Complet** : 100% des pages en architecture MVC
- ✅ **0 Styles Inline** : Toutes les classes CSS externalisées
- ✅ **Hero Unifié** : Système de hero sections cohérent
- ✅ **Classes Utilitaires** : `.icon-*`, `.sticky-nav`, `.icon-circle`

### Performance
- ✅ **Cache Busting** : Versioning automatique des CSS/JS
- ✅ **Responsive** : 100% compatible mobile/tablette/desktop
- ✅ **Optimisation CSS** : Réduction de 29% des `!important`
- ✅ **Code Propre** : 0 duplication, 0 conflit

### Contenu
- ✅ **382 Formations** : Toutes catégorisées et complètes
- ✅ **382 Articles** : 100% liés aux formations
- ✅ **Génération Auto** : Objectifs de formation automatiques

## 🧹 Nettoyage du Projet

Pour nettoyer et réorganiser le projet :

```powershell
.\nettoyage-projet.ps1
```

Ce script va :
- Créer la structure `docs/` organisée
- Déplacer tous les fichiers MD dans les bons dossiers
- Supprimer les scripts temporaires
- Supprimer les fichiers obsolètes

## 📚 Documentation

Voir le dossier [`docs/`](docs/) pour :
- **Audits** : Analyses MVC, Responsive, Conflits CSS
- **Guides** : Quick Start, Features, Optimisation
- **Migrations** : Historique des migrations MVC
- **Corrections** : Historique des corrections

## 🧹 Bonnes Pratiques

- Gardez la structure des dossiers claire et à jour
- Placez tous les assets (JS, CSS, images) dans `public/assets/`
- Utilisez les classes CSS utilitaires plutôt que les styles inline
- Documentez toute modification structurelle majeure dans ce README
- Exécutez `nettoyage-projet.ps1` régulièrement pour maintenir l'ordre
