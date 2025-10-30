# ✅ Section CTA - Style Uniforme avec Textes Originaux

## 🎯 Objectif

Appliquer le même style visuel à la section CTA sur blog et formations, tout en conservant les textes d'origine de chaque page.

---

## 🛠️ Solution Appliquée

### 1. Partial Paramétrable

**Fichier** : `includes/partials/cta-section.php`

**Avant** : Texte fixe
```php
<h2>Besoin d'un Produit Sur-Mesure ?</h2>
<p>Nous créons des solutions personnalisées...</p>
```

**Après** : Texte paramétrable
```php
<h2><?= $ctaTitle ?? 'Besoin d\'un Produit Sur-Mesure ?' ?></h2>
<p><?= $ctaText ?? 'Nous créons des solutions personnalisées...' ?></p>
<a href="<?= $ctaLink ?? '/#contact' ?>">
    <?= $ctaButton ?? 'Nous contacter' ?>
</a>
```

**Avantages** :
- ✅ Style uniforme (dégradé, bouton, animations)
- ✅ Texte personnalisable par page
- ✅ Valeurs par défaut si non spécifiées

---

## 📝 Textes par Page

### Blog

**Fichier** : `app/Views/blog/index-content.php`

```php
<?php 
$ctaTitle = 'Vous ne trouvez pas ce que vous cherchez ?';
$ctaText = 'Contactez-nous pour des conseils personnalisés en marketing digital';
$ctaLink = '/contact';
$ctaButton = 'Nous contacter';
require_once $projectRoot . '/includes/partials/cta-section.php'; 
?>
```

**Résultat** :
```
┌─────────────────────────────────────┐
│ Vous ne trouvez pas ce que vous     │
│ cherchez ?                          │
│                                     │
│ Contactez-nous pour des conseils    │
│ personnalisés en marketing digital  │
│                                     │
│        [ Nous contacter ]           │
└─────────────────────────────────────┘
```

### Formations

**Fichier** : `app/Views/formations/index.php`

```php
<?php 
$ctaTitle = 'Vous ne trouvez pas la formation qu\'il vous faut ?';
$ctaText = 'Contactez-nous pour une formation sur-mesure adaptée à vos besoins';
$ctaLink = '/contact';
$ctaButton = 'Nous contacter';
require_once __DIR__ . '/../../../includes/partials/cta-section.php'; 
?>
```

**Résultat** :
```
┌─────────────────────────────────────┐
│ Vous ne trouvez pas la formation    │
│ qu'il vous faut ?                   │
│                                     │
│ Contactez-nous pour une formation   │
│ sur-mesure adaptée à vos besoins    │
│                                     │
│        [ Nous contacter ]           │
└─────────────────────────────────────┘
```

---

## 🎨 Style Uniforme

### Dégradé de Fond

**Identique sur toutes les pages** :
```css
background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
```

### Titre

**Style** :
```css
color: #2c3e50;
font-weight: 700;
```

**Texte variable** :
- Blog : "Vous ne trouvez pas ce que vous cherchez ?"
- Formations : "Vous ne trouvez pas la formation qu'il vous faut ?"

### Paragraphe

**Style** :
```css
color: #5a6c7d;
font-size: 1.1rem;
```

**Texte variable** :
- Blog : "Contactez-nous pour des conseils personnalisés en marketing digital"
- Formations : "Contactez-nous pour une formation sur-mesure adaptée à vos besoins"

### Bouton

**Style identique** :
```css
background-color: #0d6efd;
border-radius: 50px;
padding: 1rem 3rem;
font-weight: 600;
box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
```

**Texte** : "Nous contacter" (identique)
**Lien** : "/contact" (identique)

---

## 🎯 Animations

### Identiques sur Toutes les Pages

**Container** :
```html
<div data-aos="fade-up">
```

**Bouton** :
```html
<a data-aos="zoom-in" data-aos-delay="100">
```

**Résultat** :
- Apparition progressive depuis le bas
- Bouton zoom après 100ms
- Animations fluides

---

## 📊 Comparaison

### Avant

**Blog** :
```
Fond : Bleu uni
Texte : "Vous ne trouvez pas ce que vous cherchez ?"
Style : Basique
```

**Formations** :
```
Fond : Dégradé coloré
Texte : "Vous ne trouvez pas la formation qu'il vous faut ?"
Style : Différent
```

**Problème** : Styles différents, incohérence visuelle

### Après

**Blog** :
```
Fond : Dégradé gris-bleu élégant ✅
Texte : "Vous ne trouvez pas ce que vous cherchez ?" ✅
Style : Moderne et uniforme ✅
```

**Formations** :
```
Fond : Dégradé gris-bleu élégant ✅
Texte : "Vous ne trouvez pas la formation qu'il vous faut ?" ✅
Style : Moderne et uniforme ✅
```

**Résultat** : Même style, textes adaptés au contexte

---

## 🔧 Paramètres Disponibles

### Variables

| Variable | Description | Défaut |
|----------|-------------|--------|
| `$ctaTitle` | Titre de la section | "Besoin d'un Produit Sur-Mesure ?" |
| `$ctaText` | Texte descriptif | "Nous créons des solutions..." |
| `$ctaLink` | Lien du bouton | "/#contact" |
| `$ctaButton` | Texte du bouton | "Nous contacter" |

### Utilisation

```php
<?php 
// Définir les variables avant d'inclure le partial
$ctaTitle = 'Votre titre personnalisé';
$ctaText = 'Votre texte personnalisé';
$ctaLink = '/votre-lien';
$ctaButton = 'Votre bouton';

// Inclure le partial
require_once 'includes/partials/cta-section.php'; 
?>
```

### Valeurs par Défaut

Si les variables ne sont pas définies, le partial utilise les valeurs par défaut :

```php
<?= $ctaTitle ?? 'Besoin d\'un Produit Sur-Mesure ?' ?>
```

**Opérateur `??`** : Null coalescing
- Si `$ctaTitle` existe : utilise sa valeur
- Sinon : utilise la valeur par défaut

---

## ✅ Checklist

### Style
- [x] Dégradé gris-bleu uniforme
- [x] Titre gris foncé gras
- [x] Texte gris moyen
- [x] Bouton bleu arrondi
- [x] Ombre portée
- [x] Animations AOS

### Textes
- [x] Blog : Texte d'origine conservé
- [x] Formations : Texte d'origine conservé
- [x] Contexte adapté à chaque page
- [x] Bouton identique

### Fonctionnalités
- [x] Partial paramétrable
- [x] Valeurs par défaut
- [x] Réutilisable
- [x] Maintenable

### Tests
- [ ] Blog : Style + Texte correct
- [ ] Formations : Style + Texte correct
- [ ] Responsive : OK
- [ ] Animations : Fluides

---

## 🚀 Résultat Final

**Style Uniforme** :
- ✅ Même dégradé de fond
- ✅ Même typographie
- ✅ Même bouton
- ✅ Mêmes animations

**Textes Adaptés** :
- ✅ Blog : Texte marketing digital
- ✅ Formations : Texte formation
- ✅ Contexte pertinent
- ✅ Cohérence sémantique

**Avantages** :
- ✅ Cohérence visuelle globale
- ✅ Flexibilité du contenu
- ✅ Maintenabilité optimale
- ✅ Réutilisabilité maximale

---

**Date** : 27 Octobre 2025
**Version** : 17.1 - CTA Style Uniforme + Textes Originaux
**Status** : ✅ Parfait

© 2025 Digita Marketing
