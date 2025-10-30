# 🏗️ Migration vers Layout MVC

## 🎯 Objectif

Créer une structure MVC propre avec un layout principal uniforme basé sur la page d'accueil.

---

## 📋 Structure Créée

### 1. Layout Principal
**Fichier** : `app/Views/layouts/main.php`

**Contient** :
- `<head>` avec tous les CSS
- Navbar (inclusion)
- Zone de contenu (`$content`)
- Footer (inclusion)
- Scripts JS

**Avantages** :
- ✅ Un seul endroit pour les styles
- ✅ Pas de duplication
- ✅ Facile à maintenir

### 2. Helper de Vue
**Fichier** : `app/Helpers/ViewHelper.php`

**Méthodes** :
- `render($view, $data, $layout)` - Rend une vue avec layout
- `renderPartial($view, $data)` - Rend une vue sans layout

### 3. Vues de Contenu
**Exemple** : `app/Views/blog/index-content.php`

**Contient** :
- Uniquement le contenu de la page
- Pas de `<html>`, `<head>`, `<body>`
- Pas d'inclusion de header/footer

---

## 🔧 Comment Migrer un Contrôleur

### Avant (Ancien Système)

```php
<?php
// app/Controllers/BlogController.php

class BlogController
{
    public function index()
    {
        $data = [
            'articles' => $this->getArticles(),
            'categories' => $this->getCategories()
        ];
        
        // Ancien système : inclusion manuelle
        require_once __DIR__ . '/../Views/blog/index.php';
    }
}
```

**Fichier vue** : `app/Views/blog/index.php`
```php
<?php require_once __DIR__ . '/../../../includes/partials/header.php'; ?>
<?php require_once __DIR__ . '/../../../includes/partials/navbar.php'; ?>

<link rel="stylesheet" href="/assets/css/blog.css">

<!-- Contenu de la page -->
<section>...</section>

<?php require_once __DIR__ . '/../../../includes/partials/footer.php'; ?>
```

### Après (Nouveau Système MVC)

```php
<?php
// app/Controllers/BlogController.php

require_once __DIR__ . '/../Helpers/ViewHelper.php';

class BlogController
{
    public function index()
    {
        $data = [
            'title' => 'Blog - Digita Marketing',
            'totalArticles' => 384,
            'popularArticles' => $this->getPopularArticles(),
            'recentArticles' => $this->getRecentArticles(),
            'categories' => $this->getCategories()
        ];
        
        // Nouveau système : utilisation du helper
        ViewHelper::render('blog/index-content', $data);
    }
}
```

**Fichier vue** : `app/Views/blog/index-content.php`
```php
<!-- Hero Section Blog -->
<section class="page-hero hero-blog">
    <div class="container">
        <h1><?= $title ?></h1>
        <!-- Contenu -->
    </div>
</section>

<!-- Contenu principal -->
<section class="main-content py-5">
    <!-- Articles -->
</section>
```

---

## 📁 Plan de Migration

### Phase 1 : Blog (PRIORITAIRE)

**Fichiers à migrer** :
1. ✅ `app/Views/blog/index-content.php` (créé)
2. ⏳ `app/Views/blog/show-content.php`
3. ⏳ `app/Views/blog/category-content.php`
4. ⏳ `app/Views/blog/search-content.php`

**Contrôleur** :
- ⏳ `app/Controllers/BlogController.php`

### Phase 2 : Formations

**Fichiers à créer** :
1. ⏳ `app/Views/formations/index-content.php`
2. ⏳ `app/Views/formations/show-content.php`
3. ⏳ `app/Views/formations/category-content.php`
4. ⏳ `app/Views/formations/search-content.php`

**Contrôleur** :
- ⏳ `app/Controllers/FormationController.php`

### Phase 3 : Boutique

**Fichiers à créer** :
1. ⏳ `app/Views/boutique/index-content.php`
2. ⏳ `app/Views/boutique/show-content.php`

**Contrôleur** :
- ⏳ `app/Controllers/BoutiqueController.php`

### Phase 4 : Solutions

**Fichiers à créer** :
1. ⏳ `app/Views/solutions/index-content.php`

**Contrôleur** :
- ⏳ `app/Controllers/SolutionsController.php`

### Phase 5 : Outils

**Fichiers à créer** :
1. ⏳ `app/Views/outils/index-content.php`

**Contrôleur** :
- ⏳ `app/Controllers/OutilsController.php`

---

## 🎨 Classes CSS Uniformes

### Hero Sections

```html
<!-- Blog -->
<section class="page-hero hero-blog">

<!-- Formations -->
<section class="page-hero hero-formations">

<!-- Boutique -->
<section class="page-hero hero-boutique">

<!-- Solutions -->
<section class="page-hero hero-solutions">

<!-- Outils -->
<section class="page-hero hero-outils">
```

### Contenu Principal

```html
<section class="main-content py-5">
    <div class="container">
        <!-- Contenu -->
    </div>
</section>
```

### Section CTA

```html
<section class="cta-section">
    <div class="container text-center">
        <h2>Titre</h2>
        <p class="lead">Description</p>
        <a href="/contact" class="btn btn-light btn-lg">
            <i class="bi bi-envelope"></i> Nous contacter
        </a>
    </div>
</section>
```

---

## 🔍 Exemple Complet : Migration Blog

### 1. Créer la Vue de Contenu

**Fichier** : `app/Views/blog/index-content.php`

```php
<!-- Hero -->
<section class="page-hero hero-blog">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">📝 Blog Digita</h1>
        <p class="lead mb-4">
            Découvrez nos guides complets...
        </p>
    </div>
</section>

<!-- Contenu -->
<section class="main-content py-5">
    <div class="container">
        <h2>Articles</h2>
        <!-- Liste des articles -->
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="container text-center">
        <h2>Contactez-nous</h2>
        <a href="/contact" class="btn btn-light btn-lg">Nous contacter</a>
    </div>
</section>
```

### 2. Modifier le Contrôleur

**Fichier** : `app/Controllers/BlogController.php`

```php
<?php

require_once __DIR__ . '/../Helpers/ViewHelper.php';

class BlogController
{
    public function index()
    {
        // Récupérer les données
        $popularArticles = $this->getPopularArticles();
        $recentArticles = $this->getRecentArticles();
        $categories = $this->getCategories();
        
        // Préparer les données pour la vue
        $data = [
            'title' => 'Blog - Digita Marketing',
            'totalArticles' => count($popularArticles) + count($recentArticles),
            'popularArticles' => $popularArticles,
            'recentArticles' => $recentArticles,
            'categories' => $categories
        ];
        
        // Rendre la vue avec le layout
        ViewHelper::render('blog/index-content', $data);
    }
    
    private function getPopularArticles()
    {
        // Votre logique existante
        return [];
    }
    
    private function getRecentArticles()
    {
        // Votre logique existante
        return [];
    }
    
    private function getCategories()
    {
        // Votre logique existante
        return [];
    }
}
```

### 3. Tester

```
1. Allez sur /blog
2. Vérifiez que :
   - Le hero est affiché ✅
   - Les articles sont affichés ✅
   - Le CTA est affiché ✅
   - Le style est uniforme ✅
```

---

## ✅ Avantages du Nouveau Système

### Pour le Développement
- ✅ Séparation claire des responsabilités
- ✅ Réutilisation du layout
- ✅ Pas de duplication de code
- ✅ Facile à maintenir

### Pour le Design
- ✅ Styles uniformes garantis
- ✅ Un seul endroit pour les CSS
- ✅ Cohérence visuelle automatique

### Pour la Performance
- ✅ Moins de fichiers CSS chargés
- ✅ Pas de conflits CSS
- ✅ Cache navigateur optimisé

---

## 🚀 Prochaines Étapes

### Étape 1 : Tester le Layout
```
1. Créer un contrôleur de test
2. Créer une vue de test
3. Vérifier que le layout fonctionne
```

### Étape 2 : Migrer Blog
```
1. Créer toutes les vues de contenu blog
2. Modifier BlogController
3. Tester toutes les pages blog
```

### Étape 3 : Migrer Formations
```
1. Créer toutes les vues de contenu formations
2. Modifier FormationController
3. Tester toutes les pages formations
```

### Étape 4 : Migrer Autres Pages
```
1. Boutique
2. Solutions
3. Outils
```

---

## 📊 Checklist de Migration

### Layout Principal
- [x] Créer `app/Views/layouts/main.php`
- [x] Ajouter tous les styles CSS
- [x] Inclure navbar et footer
- [x] Tester le layout vide

### Helper
- [x] Créer `app/Helpers/ViewHelper.php`
- [x] Méthode `render()`
- [x] Méthode `renderPartial()`

### Blog
- [x] Créer `app/Views/blog/index-content.php`
- [ ] Créer `app/Views/blog/show-content.php`
- [ ] Créer `app/Views/blog/category-content.php`
- [ ] Créer `app/Views/blog/search-content.php`
- [ ] Modifier `app/Controllers/BlogController.php`

### Formations
- [ ] Créer toutes les vues de contenu
- [ ] Modifier le contrôleur

### Autres Pages
- [ ] Boutique
- [ ] Solutions
- [ ] Outils

---

**Date** : 27 Octobre 2025
**Version** : 10.0 - Structure MVC avec Layout
**Status** : 🚧 En Migration

© 2025 Digita Marketing
