# Digita Marketing - Système de Gestion des Tâches

Système de gestion des tâches marketing pour l'agence Digita, permettant de gérer et suivre les campagnes marketing, les newsletters et les performances.

## 🚀 Fonctionnalités

- Gestion des tâches marketing
- Système de newsletters
- Suivi des performances
- Génération de rapports
- API RESTful
- Interface d'administration

## 📋 Prérequis

- PHP 8.2+
- MySQL 8.0+
- Wampserver 3.2+
- Composer (pour les dépendances)

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
http://waohost/digita-marketing/
```

2. Se connecter avec :
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
http://waohost/digita-marketing/api-docs/ui.php
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
