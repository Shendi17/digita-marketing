# 🚀 Migration MVC - Pages Restantes (En cours)

## 📋 Pages à Migrer

| Page | URL | Hero | Status |
|------|-----|------|--------|
| À propos | `/a-propos` | Bleu | ✅ Contrôleur créé |
| Services | `/services` | Bleu | ✅ Contrôleur créé |
| Contact | `/contact` | Bleu | ✅ Terminé |
| Support | `/support` | Bleu | ✅ Contrôleur créé |
| Tarifs | `/tarifs` | Bleu | ✅ Contrôleur créé |

## ✅ Fichiers Créés

### Contrôleurs (5)
- `app/Controllers/AboutController.php` ✅
- `app/Controllers/ServicesController.php` ✅
- `app/Controllers/ContactController.php` ✅
- `app/Controllers/SupportController.php` ✅
- `app/Controllers/TarifsController.php` ✅

### Vues (1/5)
- `app/Views/contact/index-content.php` ✅
- `app/Views/about/index-content.php` ⏳
- `app/Views/services/index-content.php` ⏳
- `app/Views/support/index-content.php` ⏳
- `app/Views/tarifs/index-content.php` ⏳

### CSS (1/5)
- `public/assets/css/contact.css` ✅
- `public/assets/css/about.css` ⏳
- `public/assets/css/services.css` ⏳
- `public/assets/css/support.css` ⏳
- `public/assets/css/tarifs.css` ⏳

## 🎯 Principe

### Hero Bleu Conservé
```html
<section class="{page}-hero py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-4">{Titre}</h1>
                <p class="lead mb-0">{Sous-titre}</p>
            </div>
        </div>
    </div>
</section>
```

### CSS Hero
```css
.{page}-hero {
    margin-top: 0 !important;
    padding-top: 120px !important;
}
```

### Styles Inline → CSS
Tous les `style="..."` sont remplacés par des classes CSS.

Exemple :
```html
<!-- Avant -->
<div style="width: 70px; height: 70px;">

<!-- Après -->
<div class="icon-circle">
```

```css
.icon-circle {
    width: 70px;
    height: 70px;
}
```

## 📊 Styles Inline Identifiés

### Contact ✅
- `style="width: 70px; height: 70px;"` → `.contact-icon-circle`

### About
- `style="width: 60px; height: 60px;"` → `.about-icon-circle`

### Services
- À identifier

### Support
- À identifier

### Tarifs
- À identifier

## 🔄 Routes à Mettre à Jour

```php
// À propos
$router->get('/a-propos', function() {
    require_once __DIR__ . '/../app/Controllers/AboutController.php';
    $controller = new AboutController();
    $controller->index();
});

// Services
$router->get('/services', function() {
    require_once __DIR__ . '/../app/Controllers/ServicesController.php';
    $controller = new ServicesController();
    $controller->index();
});

// Contact
$router->get('/contact', function() {
    require_once __DIR__ . '/../app/Controllers/ContactController.php';
    $controller = new ContactController();
    $controller->index();
});

// Support
$router->get('/support', function() {
    require_once __DIR__ . '/../app/Controllers/SupportController.php';
    $controller = new SupportController();
    $controller->index();
});

// Tarifs
$router->get('/tarifs', function() {
    require_once __DIR__ . '/../app/Controllers/TarifsController.php';
    $controller = new TarifsController();
    $controller->index();
});
```

## ⏳ Prochaines Étapes

1. ✅ Créer les contrôleurs
2. ⏳ Créer les vues content (4 restantes)
3. ⏳ Créer les CSS (4 restants)
4. ⏳ Mettre à jour les routes
5. ⏳ Tester chaque page

---

**Status** : En cours (20% terminé)
**Date** : 28 Octobre 2025
