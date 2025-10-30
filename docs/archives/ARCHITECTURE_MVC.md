# Architecture MVC - Dashboard Admin Digita Marketing

## 📋 Vue d'ensemble

Le dashboard admin a été complètement modernisé avec une architecture **MVC (Model-View-Controller)** propre et maintenable.

---

## 🏗️ Structure des dossiers

```
digita-marketing/
├── app/
│   ├── Controllers/
│   │   ├── Controller.php          # Contrôleur de base
│   │   └── AdminController.php     # Contrôleur admin
│   ├── Models/
│   │   ├── Model.php               # Modèle de base (CRUD)
│   │   ├── User.php                # Modèle utilisateurs
│   │   ├── Contact.php             # Modèle messages de contact
│   │   └── Newsletter.php          # Modèle abonnés newsletter
│   └── Views/
│       ├── layouts/
│       │   └── admin.php           # Layout principal admin
│       └── admin/
│           ├── dashboard.php       # Vue dashboard
│           ├── contacts.php        # Vue gestion contacts
│           └── newsletters.php     # Vue gestion newsletters
├── public/
│   ├── assets/
│   │   ├── css/admin/
│   │   │   └── dashboard.css       # Styles modernes
│   │   └── js/admin/
│   │       └── dashboard.js        # Scripts interactifs
│   └── index.php                   # Point d'entrée + routes
└── includes/
    ├── Database.php                # Singleton PDO
    └── Router.php                  # Routeur simple
```

---

## 🎯 Composants MVC

### 1. **Models** (app/Models/)

Les modèles gèrent la logique métier et l'accès aux données.

#### Model.php (Classe de base)
Fournit les méthodes CRUD de base :
- `all()` - Récupérer tous les enregistrements
- `find($id)` - Trouver par ID
- `where($column, $value)` - Filtrer
- `count()` - Compter
- `create($data)` - Créer
- `update($id, $data)` - Mettre à jour
- `delete($id)` - Supprimer

#### User.php
```php
$userModel = new User();
$user = $userModel->findByEmail('admin@digita.com');
$stats = $userModel->getStats();
```

#### Contact.php
```php
$contactModel = new Contact();
$recentContacts = $contactModel->getRecent(10);
$newMessages = $contactModel->getNew();
$stats = $contactModel->getStats();
```

#### Newsletter.php
```php
$newsletterModel = new Newsletter();
$activeSubscribers = $newsletterModel->getActive();
$newsletterModel->subscribe('email@example.com');
$emails = $newsletterModel->exportEmails();
```

---

### 2. **Controllers** (app/Controllers/)

Les contrôleurs gèrent la logique de l'application et coordonnent les modèles et vues.

#### Controller.php (Classe de base)
Méthodes utilitaires :
- `view($viewPath, $data)` - Charger une vue
- `viewWithLayout($viewPath, $data, $layout)` - Vue avec layout
- `redirect($url)` - Redirection
- `json($data)` - Réponse JSON
- `requireAuth()` - Vérifier authentification
- `requireAdmin()` - Vérifier rôle admin

#### AdminController.php
Actions disponibles :
- `dashboard()` - Page principale
- `contacts()` - Gestion des messages
- `newsletters()` - Gestion des abonnés
- `markContactAsRead($id)` - Marquer message lu
- `markContactAsReplied($id)` - Marquer message répondu
- `exportNewsletters()` - Exporter CSV
- `logout()` - Déconnexion

---

### 3. **Views** (app/Views/)

Les vues affichent les données fournies par les contrôleurs.

#### Layout admin (layouts/admin.php)
- Navbar responsive avec navigation
- Affichage utilisateur connecté
- Footer
- Inclusion automatique des vues

#### Vues admin
- **dashboard.php** - Statistiques, messages récents, abonnés récents
- **contacts.php** - Liste complète des messages avec filtres
- **newsletters.php** - Liste des abonnés avec export

---

## 🎨 Design moderne

### Caractéristiques
- ✅ Design moderne avec dégradés
- ✅ Cartes statistiques animées
- ✅ Interface responsive (mobile-first)
- ✅ Icônes Bootstrap Icons
- ✅ Typographie Inter (Google Fonts)
- ✅ Animations CSS fluides
- ✅ Thème cohérent avec variables CSS

### Palette de couleurs
```css
--primary: #6366f1 (Indigo)
--success: #10b981 (Vert)
--info: #3b82f6 (Bleu)
--warning: #f59e0b (Orange)
--danger: #ef4444 (Rouge)
```

---

## 🛣️ Routes

### Routes publiques
```
GET  /                    → Page d'accueil
GET  /connexion           → Formulaire connexion
POST /connexion           → Traitement connexion
```

### Routes admin (MVC)
```
GET  /admin/dashboard              → Dashboard principal
GET  /admin/contacts               → Liste des messages
GET  /admin/contacts/read?id=X     → Marquer message lu
GET  /admin/contacts/replied?id=X  → Marquer message répondu
GET  /admin/newsletters            → Liste des abonnés
GET  /admin/newsletters/export     → Exporter CSV
GET  /admin/logout                 → Déconnexion
```

### Routes admin (anciennes - compatibilité)
```
GET  /admin/webhooks      → Gestion webhooks
GET  /admin/campaigns     → Gestion campagnes
```

---

## 📊 Statistiques affichées

### Dashboard
- **Messages de contact** : Total, nouveaux, cette semaine
- **Abonnés newsletter** : Total actifs, nouveaux cette semaine
- **Utilisateurs** : Total, admins
- **Taux de conversion** : Contact → Newsletter

### Page Contacts
- Total messages
- Nouveaux (non lus)
- Lus
- Répondus

### Page Newsletters
- Total abonnés
- Actifs
- Inactifs
- Nouveaux cette semaine

---

## 🔐 Sécurité

### Authentification
- Vérification de session dans chaque contrôleur admin
- Redirection automatique si non connecté
- Vérification du rôle admin

### Protection des données
- Échappement HTML avec `htmlspecialchars()`
- Requêtes préparées (PDO)
- Validation des entrées

---

## 🚀 Utilisation

### Accéder au dashboard
1. Se connecter : `http://digita.local/digita-marketing/connexion`
   - Email : `admin@digita.com`
   - Mot de passe : `admin123`

2. Accéder au dashboard : `http://digita.local/digita-marketing/admin/dashboard`

### Créer un nouveau contrôleur
```php
<?php
require_once __DIR__ . '/Controller.php';

class MonController extends Controller {
    public function index() {
        $data = ['titre' => 'Ma page'];
        $this->viewWithLayout('mon-dossier/ma-vue', $data);
    }
}
```

### Créer un nouveau modèle
```php
<?php
require_once __DIR__ . '/Model.php';

class MonModele extends Model {
    protected $table = 'ma_table';
    
    public function maMethode() {
        return $this->all('created_at DESC');
    }
}
```

### Ajouter une route
```php
// Dans public/index.php
$router->get('/ma-route', function() {
    require_once __DIR__ . '/../app/Controllers/MonController.php';
    $controller = new MonController();
    $controller->index();
});
```

---

## 📦 Dépendances

### Frontend
- Bootstrap 5.3.2
- Bootstrap Icons 1.11.1
- Google Fonts (Inter)

### Backend
- PHP 7.4+
- MySQL/MariaDB
- PDO

---

## 🔄 Migration depuis l'ancien dashboard

L'ancien dashboard (`public/admin/dashboard.php`) est toujours présent mais **non utilisé**.

Le nouveau dashboard MVC est accessible via les routes `/admin/*`.

### Différences principales
| Ancien | Nouveau MVC |
|--------|-------------|
| Tout dans un fichier | Séparation MVC |
| Données factices | Données réelles DB |
| CSS inline | CSS externe modulaire |
| Pas de réutilisabilité | Composants réutilisables |
| Difficile à maintenir | Facile à étendre |

---

## 🎓 Bonnes pratiques

1. **Toujours** passer par les modèles pour accéder aux données
2. **Ne jamais** mettre de logique métier dans les vues
3. **Utiliser** les méthodes du contrôleur de base
4. **Échapper** toutes les données affichées
5. **Tester** chaque nouvelle fonctionnalité

---

## 📝 TODO / Améliorations futures

- [ ] Pagination pour les listes longues
- [ ] Recherche et filtres avancés
- [ ] Graphiques avec Chart.js
- [ ] Notifications en temps réel
- [ ] Export PDF des rapports
- [ ] Gestion des utilisateurs (CRUD)
- [ ] Logs d'activité admin
- [ ] API REST pour mobile

---

## 👨‍💻 Auteur

Architecture MVC créée le 25 octobre 2025
Version 2.0 - Digita Marketing

---

## 📄 Licence

Tous droits réservés © 2025 Digita Marketing
