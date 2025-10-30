# 📋 Instructions Finalisation Migration MVC

## ✅ Déjà Terminé

### Contrôleurs (5/5) ✅
- `AboutController.php`
- `ServicesController.php`
- `ContactController.php`
- `SupportController.php`
- `TarifsController.php`

### Vues (1/5) ✅
- `contact/index-content.php`

### CSS (2/5) ✅
- `contact.css`
- `about.css`

---

## 🔄 À Terminer

### 1. Créer les Vues Restantes (4)

Pour chaque page, copier le contenu de `templates/{page}.php` et :
1. Supprimer les 5 premières lignes PHP (`<?php ... ob_start(); ?>`)
2. Supprimer la dernière ligne (`<?php $content = ob_get_clean(); require __DIR__ . '/layout.php'; ?>`)
3. Remplacer `class="py-5 bg-primary text-white"` par `class="{page}-hero py-5 bg-primary text-white"`
4. Remplacer tous les `style="width: Xpx; height: Ypx;"` par `class="{page}-icon-circle"`

**Fichiers à créer** :
- `app/Views/about/index-content.php`
- `app/Views/services/index-content.php`
- `app/Views/support/index-content.php`
- `app/Views/tarifs/index-content.php`

---

### 2. Créer les CSS Restants (3)

**Template CSS** :
```css
/* ==================== {PAGE} STYLES ==================== */

/* Hero Section - Bleu (conservé) */
.{page}-hero {
    margin-top: 0 !important;
    padding-top: 120px !important;
}

/* Icon Circle - Remplace style inline */
.{page}-icon-circle {
    width: 60px;  /* ou 70px selon la page */
    height: 60px; /* ou 70px selon la page */
}

/* Responsive */
@media (max-width: 768px) {
    .{page}-hero {
        padding-top: 100px !important;
    }
}
```

**Fichiers à créer** :
- `public/assets/css/services.css`
- `public/assets/css/support.css`
- `public/assets/css/tarifs.css`

---

### 3. Mettre à Jour les Routes

**Fichier** : `public/index.php`

**Remplacer** :
```php
// Page À propos
$router->get('/a-propos', function() {
    require_once __DIR__ . '/../templates/about.php';
});

// Page Services
$router->get('/services', function() {
    require_once __DIR__ . '/../templates/services.php';
});

// Page Contact
$router->get('/contact', function() {
    require_once __DIR__ . '/../templates/contact.php';
});

// Page Support
$router->get('/support', function() {
    require_once __DIR__ . '/../templates/support.php';
});

// Page Tarifs
$router->get('/tarifs', function() {
    require_once __DIR__ . '/../templates/tarifs.php';
});
```

**Par** :
```php
// Page À propos
$router->get('/a-propos', function() {
    require_once __DIR__ . '/../app/Controllers/AboutController.php';
    $controller = new AboutController();
    $controller->index();
});

// Page Services
$router->get('/services', function() {
    require_once __DIR__ . '/../app/Controllers/ServicesController.php';
    $controller = new ServicesController();
    $controller->index();
});

// Page Contact
$router->get('/contact', function() {
    require_once __DIR__ . '/../app/Controllers/ContactController.php';
    $controller = new ContactController();
    $controller->index();
});

// Page Support
$router->get('/support', function() {
    require_once __DIR__ . '/../app/Controllers/SupportController.php';
    $controller = new SupportController();
    $controller->index();
});

// Page Tarifs
$router->get('/tarifs', function() {
    require_once __DIR__ . '/../app/Controllers/TarifsController.php';
    $controller = new TarifsController();
    $controller->index();
});
```

---

## 🎯 Résumé des Modifications

### Pour Chaque Page

#### 1. Vue HTML
- ❌ Supprimer : `<?php $pageTitle = ...; $extraCss = ...; ob_start(); ?>`
- ❌ Supprimer : `<?php $content = ob_get_clean(); require __DIR__ . '/layout.php'; ?>`
- ✅ Ajouter classe hero : `.{page}-hero`
- ✅ Remplacer styles inline par classes CSS

#### 2. CSS
- ✅ Hero avec `margin-top: 0` et `padding-top: 120px`
- ✅ Classes pour remplacer styles inline
- ✅ Responsive

#### 3. Route
- ✅ Utiliser le contrôleur au lieu du template

---

## 📊 Checklist Finale

### About
- [x] Contrôleur créé
- [x] CSS créé
- [ ] Vue créée
- [ ] Route mise à jour
- [ ] Testé

### Services
- [x] Contrôleur créé
- [ ] CSS créé
- [ ] Vue créée
- [ ] Route mise à jour
- [ ] Testé

### Contact
- [x] Contrôleur créé
- [x] CSS créé
- [x] Vue créée
- [ ] Route mise à jour
- [ ] Testé

### Support
- [x] Contrôleur créé
- [ ] CSS créé
- [ ] Vue créée
- [ ] Route mise à jour
- [ ] Testé

### Tarifs
- [x] Contrôleur créé
- [ ] CSS créé
- [ ] Vue créée
- [ ] Route mise à jour
- [ ] Testé

---

## 🧪 Tests

Après chaque page migrée :

```
1. Ctrl + Shift + R (vider le cache)
2. Tester la page : /{page}
3. Vérifier :
   ✅ Hero bleu affiché
   ✅ Pas de styles inline
   ✅ Layout MVC (navbar + footer)
   ✅ Contenu identique
```

---

## 💡 Exemple Complet : About

### 1. Vue (`app/Views/about/index-content.php`)
```html
<!-- Hero Section -->
<section class="about-hero py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
                <h1 class="display-4 fw-bold mb-4">À Propos de Digita Marketing</h1>
                <p class="lead mb-0">Apprendre à nous connaître</p>
            </div>
        </div>
    </div>
</section>

<!-- Contenu (copié depuis template) -->
<section class="py-5 bg-white">
    <!-- ... reste du contenu ... -->
    <!-- Remplacer style="width: 60px; height: 60px;" par class="about-icon-circle" -->
</section>
```

### 2. CSS (`public/assets/css/about.css`)
```css
/* ==================== ABOUT STYLES ==================== */

.about-hero {
    margin-top: 0 !important;
    padding-top: 120px !important;
}

.about-icon-circle {
    width: 60px;
    height: 60px;
}

@media (max-width: 768px) {
    .about-hero {
        padding-top: 100px !important;
    }
}
```

### 3. Route (`public/index.php`)
```php
$router->get('/a-propos', function() {
    require_once __DIR__ . '/../app/Controllers/AboutController.php';
    $controller = new AboutController();
    $controller->index();
});
```

---

**Date** : 28 Octobre 2025
**Status** : 40% terminé
**Prochaine étape** : Créer les 4 vues restantes
