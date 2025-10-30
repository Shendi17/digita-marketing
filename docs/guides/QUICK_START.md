# ⚡ Quick Start - Dashboard Admin MVC

## 🚀 Démarrage Rapide en 3 Étapes

### 1️⃣ Vérifier l'installation

```bash
php test_mvc.php
```

**Résultat attendu :** Tous les tests doivent passer ✅

---

### 2️⃣ Se connecter

**URL :** http://digita.local/digita-marketing/connexion

**Identifiants :**
```
Email: admin@digita.com
Mot de passe: admin123
```

---

### 3️⃣ Accéder au dashboard

**URL :** http://digita.local/digita-marketing/admin/dashboard

---

## 📍 URLs Importantes

| Page | URL |
|------|-----|
| **Dashboard** | `/admin/dashboard` |
| **Messages** | `/admin/contacts` |
| **Newsletter** | `/admin/newsletters` |
| **Webhooks** | `/admin/webhooks` |
| **Campagnes** | `/admin/campaigns` |
| **Déconnexion** | `/admin/logout` |

---

## 🎯 Fonctionnalités Principales

### Dashboard
- ✅ Statistiques en temps réel
- ✅ Messages récents
- ✅ Abonnés récents
- ✅ Actions rapides

### Gestion Messages
- ✅ Liste complète
- ✅ Marquer comme lu/répondu
- ✅ Statistiques détaillées
- ✅ Réponse par email

### Gestion Newsletter
- ✅ Liste des abonnés
- ✅ Export CSV
- ✅ Statistiques

---

## 📁 Structure MVC

```
app/
├── Controllers/
│   ├── Controller.php          # Base
│   └── AdminController.php     # Admin
├── Models/
│   ├── Model.php               # Base CRUD
│   ├── User.php                # Utilisateurs
│   ├── Contact.php             # Messages
│   └── Newsletter.php          # Abonnés
└── Views/
    ├── layouts/admin.php       # Layout
    └── admin/
        ├── dashboard.php       # Dashboard
        ├── contacts.php        # Messages
        └── newsletters.php     # Newsletter
```

---

## 🎨 Design

### Couleurs
- **Primary:** #6366f1 (Indigo)
- **Success:** #10b981 (Vert)
- **Info:** #3b82f6 (Bleu)
- **Warning:** #f59e0b (Orange)
- **Danger:** #ef4444 (Rouge)

### Typographie
- **Police:** Inter (Google Fonts)
- **Tailles:** 300, 400, 500, 600, 700, 800

---

## 💻 Exemples de Code

### Utiliser un modèle

```php
require_once 'app/Models/Contact.php';
$contactModel = new Contact();

// Récupérer tous les messages
$messages = $contactModel->all();

// Récupérer les nouveaux
$newMessages = $contactModel->getNew();

// Statistiques
$stats = $contactModel->getStats();
```

### Créer une route

```php
// Dans public/index.php
$router->get('/admin/ma-page', function() {
    require_once __DIR__ . '/../app/Controllers/AdminController.php';
    $controller = new AdminController();
    $controller->maMethode();
});
```

---

## 🐛 Débogage

### Vérifier les logs

```bash
# Erreurs
tail -f logs/error.log

# Exceptions
tail -f logs/exception.log
```

### Activer le mode debug

Dans `config/config.php` :
```php
define('ENVIRONMENT', 'development');
```

---

## 📚 Documentation Complète

- **Architecture MVC** → `ARCHITECTURE_MVC.md`
- **Guide utilisateur** → `README_DASHBOARD_MVC.md`
- **Résumé projet** → `RESUME_PROJET.md`
- **Corrections** → `CORRECTIONS_CONNEXION.md`

---

## ✅ Checklist de Vérification

Avant de commencer :

- [ ] PHP 7.4+ installé
- [ ] MySQL/MariaDB en cours d'exécution
- [ ] Base de données `digita_marketing` créée
- [ ] Tables `users`, `contact_messages`, `newsletters` présentes
- [ ] Utilisateur admin créé
- [ ] Serveur web configuré (Apache/Nginx)
- [ ] Extension PDO PHP activée

---

## 🆘 Problèmes Courants

### Connexion ne fonctionne pas
```bash
# Réinitialiser le mot de passe
php fix_password.php
```

### Erreur 404 sur les routes
- Vérifier que mod_rewrite est activé
- Vérifier le fichier `.htaccess`

### Erreur de base de données
- Vérifier les identifiants dans `config/config.php`
- Vérifier que MySQL est démarré

---

## 🎉 C'est Parti !

Vous êtes prêt à utiliser le dashboard admin moderne avec architecture MVC.

**Bon développement ! 🚀**

---

**Version 2.0** - Dashboard Admin MVC
© 2025 Digita Marketing
