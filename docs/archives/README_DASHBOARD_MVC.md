# 🚀 Dashboard Admin MVC - Digita Marketing

Dashboard d'administration moderne avec architecture **MVC** (Model-View-Controller) pour la gestion du site Digita Marketing.

![Version](https://img.shields.io/badge/version-2.0-blue)
![PHP](https://img.shields.io/badge/PHP-7.4+-purple)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3.2-purple)
![License](https://img.shields.io/badge/license-Proprietary-red)

---

## ✨ Fonctionnalités

### 📊 Dashboard Principal
- **Statistiques en temps réel** depuis la base de données
- **Cartes animées** avec design moderne
- **Messages récents** avec statuts (nouveau, lu, répondu)
- **Abonnés newsletter** récents
- **Taux de conversion** Contact → Newsletter
- **Actions rapides** vers les sections principales

### 📧 Gestion des Messages
- Liste complète des messages de contact
- Filtrage par statut (nouveau, lu, répondu)
- Marquage rapide des messages
- Statistiques détaillées
- Réponse directe par email

### 📰 Gestion Newsletter
- Liste des abonnés actifs/inactifs
- Statistiques d'abonnement
- Export CSV des emails
- Envoi direct d'emails

### 🔐 Sécurité
- Authentification requise
- Vérification du rôle admin
- Protection CSRF
- Échappement des données
- Requêtes préparées (PDO)

---

## 🎨 Design Moderne

### Caractéristiques visuelles
- ✅ **Dégradés modernes** (Indigo → Violet)
- ✅ **Animations fluides** CSS
- ✅ **Responsive design** (Mobile-first)
- ✅ **Icônes Bootstrap Icons**
- ✅ **Typographie Inter** (Google Fonts)
- ✅ **Cartes avec hover effects**
- ✅ **Badges de statut colorés**

### Palette de couleurs
```
Primary:   #6366f1 (Indigo)
Success:   #10b981 (Vert)
Info:      #3b82f6 (Bleu)
Warning:   #f59e0b (Orange)
Danger:    #ef4444 (Rouge)
```

---

## 📁 Structure du Projet

```
digita-marketing/
│
├── app/                          # Application MVC
│   ├── Controllers/
│   │   ├── Controller.php        # Contrôleur de base
│   │   └── AdminController.php   # Contrôleur admin
│   ├── Models/
│   │   ├── Model.php             # Modèle de base (CRUD)
│   │   ├── User.php              # Gestion utilisateurs
│   │   ├── Contact.php           # Gestion messages
│   │   └── Newsletter.php        # Gestion abonnés
│   └── Views/
│       ├── layouts/
│       │   └── admin.php         # Layout principal
│       └── admin/
│           ├── dashboard.php     # Vue dashboard
│           ├── contacts.php      # Vue contacts
│           └── newsletters.php   # Vue newsletters
│
├── public/
│   ├── assets/
│   │   ├── css/admin/
│   │   │   └── dashboard.css     # Styles modernes
│   │   └── js/admin/
│   │       └── dashboard.js      # Scripts JS
│   └── index.php                 # Point d'entrée + Routes
│
├── config/
│   └── config.php                # Configuration
│
├── includes/
│   ├── Database.php              # Singleton PDO
│   ├── Router.php                # Routeur
│   └── auth.php                  # Authentification
│
└── docs/
    ├── ARCHITECTURE_MVC.md       # Documentation architecture
    └── README_DASHBOARD_MVC.md   # Ce fichier
```

---

## 🚀 Installation & Démarrage

### Prérequis
- PHP 7.4 ou supérieur
- MySQL/MariaDB
- Serveur web (Apache/Nginx) avec mod_rewrite
- Extension PDO PHP

### Étape 1: Configuration de la base de données

La base de données `digita_marketing` doit déjà exister avec les tables :
- `users`
- `contact_messages`
- `newsletters`

### Étape 2: Vérifier la configuration

```bash
# Tester l'architecture MVC
php test_mvc.php
```

### Étape 3: Accéder au dashboard

1. **Se connecter** :
   ```
   URL: http://digita.local/digita-marketing/connexion
   Email: admin@digita.com
   Mot de passe: admin123
   ```

2. **Accéder au dashboard** :
   ```
   URL: http://digita.local/digita-marketing/admin/dashboard
   ```

---

## 🛣️ Routes Disponibles

### Routes Admin
| Méthode | Route | Description |
|---------|-------|-------------|
| GET | `/admin/dashboard` | Dashboard principal |
| GET | `/admin/contacts` | Liste des messages |
| GET | `/admin/contacts/read?id=X` | Marquer message comme lu |
| GET | `/admin/contacts/replied?id=X` | Marquer message comme répondu |
| GET | `/admin/newsletters` | Liste des abonnés |
| GET | `/admin/newsletters/export` | Exporter CSV |
| GET | `/admin/logout` | Déconnexion |

---

## 💻 Utilisation du Code

### Utiliser un modèle

```php
// Charger le modèle
require_once __DIR__ . '/app/Models/Contact.php';
$contactModel = new Contact();

// Récupérer tous les messages
$messages = $contactModel->all();

// Récupérer les nouveaux messages
$newMessages = $contactModel->getNew();

// Récupérer les statistiques
$stats = $contactModel->getStats();

// Créer un nouveau message
$contactModel->createMessage(
    'John Doe',
    'john@example.com',
    '0123456789',
    'Demande de devis',
    'Bonjour, je souhaite...'
);
```

### Créer un contrôleur

```php
<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Models/MonModele.php';

class MonController extends Controller {
    
    public function index() {
        // Vérifier l'authentification
        $this->requireAdmin();
        
        // Récupérer les données
        $model = new MonModele();
        $data = $model->all();
        
        // Passer à la vue
        $this->viewWithLayout('admin/ma-vue', [
            'pageTitle' => 'Mon Titre',
            'data' => $data,
            'currentUser' => $this->getCurrentUser()
        ]);
    }
}
```

### Ajouter une route

```php
// Dans public/index.php
$router->get('/admin/ma-route', function() {
    require_once __DIR__ . '/../app/Controllers/MonController.php';
    $controller = new MonController();
    $controller->index();
});
```

---

## 📊 Statistiques Affichées

### Dashboard
- **Messages de contact** : Total, nouveaux, cette semaine
- **Abonnés newsletter** : Total actifs, nouveaux cette semaine  
- **Utilisateurs** : Total, nombre d'admins
- **Taux de conversion** : Pourcentage Contact → Newsletter

### Page Contacts
- Total messages reçus
- Messages non lus (nouveaux)
- Messages lus
- Messages répondus
- Messages aujourd'hui/cette semaine/ce mois

### Page Newsletters
- Total abonnés
- Abonnés actifs
- Abonnés inactifs
- Nouveaux abonnés cette semaine/ce mois

---

## 🎯 Améliorations Futures

### Court terme
- [ ] Pagination des listes
- [ ] Recherche et filtres avancés
- [ ] Tri des colonnes
- [ ] Suppression de messages/abonnés

### Moyen terme
- [ ] Graphiques avec Chart.js
- [ ] Notifications push en temps réel
- [ ] Export PDF des rapports
- [ ] Éditeur WYSIWYG pour emails

### Long terme
- [ ] API REST complète
- [ ] Application mobile (React Native)
- [ ] Gestion multi-utilisateurs avec permissions
- [ ] Système de templates d'emails
- [ ] Analytics avancés avec Google Analytics

---

## 🐛 Débogage

### Activer les erreurs PHP
Dans `config/config.php` :
```php
define('ENVIRONMENT', 'development');
```

### Vérifier les logs
```bash
# Logs d'erreurs
tail -f logs/error.log

# Logs d'exceptions
tail -f logs/exception.log
```

### Tester l'architecture
```bash
php test_mvc.php
```

---

## 📚 Documentation

- **Architecture MVC** : Voir `ARCHITECTURE_MVC.md`
- **Corrections connexion** : Voir `CORRECTIONS_CONNEXION.md`
- **Services** : Voir `docs/liste-services-complets.md`

---

## 🔧 Technologies Utilisées

### Backend
- **PHP 7.4+** - Langage serveur
- **MySQL/MariaDB** - Base de données
- **PDO** - Accès base de données
- **Architecture MVC** - Pattern de conception

### Frontend
- **Bootstrap 5.3.2** - Framework CSS
- **Bootstrap Icons 1.11.1** - Icônes
- **Google Fonts (Inter)** - Typographie
- **Vanilla JavaScript** - Interactions

---

## 👨‍💻 Développement

### Standards de code
- PSR-12 pour PHP
- Nommage en français pour les variables métier
- Commentaires en français
- Documentation en Markdown

### Git
```bash
# Ignorer les fichiers de test
git add .gitignore
echo "test_*.php" >> .gitignore
echo "check_*.php" >> .gitignore
```

---

## 📝 Changelog

### Version 2.0 (25 Oct 2025)
- ✅ Architecture MVC complète
- ✅ Design moderne avec dégradés
- ✅ Modèles User, Contact, Newsletter
- ✅ Contrôleur AdminController
- ✅ Vues dashboard, contacts, newsletters
- ✅ CSS/JS modulaires
- ✅ Routes RESTful
- ✅ Documentation complète

### Version 1.0 (Ancienne)
- Dashboard basique
- Données factices
- Pas d'architecture
- CSS inline

---

## 🤝 Support

Pour toute question ou problème :
1. Consulter `ARCHITECTURE_MVC.md`
2. Vérifier les logs dans `logs/`
3. Exécuter `php test_mvc.php`

---

## 📄 Licence

© 2025 Digita Marketing - Tous droits réservés

---

## 🎉 Remerciements

Dashboard créé avec ❤️ en utilisant :
- Bootstrap pour le design
- PHP pour la logique
- Architecture MVC pour la maintenabilité

**Bon développement ! 🚀**
