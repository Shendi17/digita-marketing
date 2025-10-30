# 📚 Génération Automatique de Contenu

## 🎯 Objectif

Ce système génère automatiquement **des articles de blog** et **des formations complètes** pour chaque service proposé par Digita Marketing.

---

## 📊 Contenu Généré

### Articles de Blog
Pour chaque service, un article complet est créé avec :
- ✅ **Introduction** - Présentation du service
- ✅ **Définition** - Qu'est-ce que le service ?
- ✅ **Avantages** - Pourquoi choisir ce service ?
- ✅ **Méthodologie** - Comment le mettre en place (4 étapes)
- ✅ **Outils** - Technologies et plateformes utilisées
- ✅ **Cas d'usage** - Exemples concrets
- ✅ **Tarifs** - Formules proposées
- ✅ **FAQ** - Questions fréquentes
- ✅ **Conclusion** - Appel à l'action

### Formations Complètes
Pour chaque service, une formation structurée avec :

#### 📖 Module 1 : Introduction
- Qu'est-ce que le service ? (15 min) 🆓
- Les enjeux et opportunités (20 min) 🆓
- Les outils et plateformes (25 min)
- Quiz de validation (10 min)

#### 🎯 Module 2 : Stratégie et planification
- Définir vos objectifs (30 min)
- Analyser votre audience (25 min)
- Créer votre plan d'action (35 min)
- Exercice pratique (20 min)

#### 💪 Module 3 : Mise en pratique
- Configuration et paramétrage (40 min)
- Création de votre première campagne (45 min)
- Optimisation et tests (30 min)
- Projet final (60 min)

#### 📊 Module 4 : Analyse et optimisation
- Les KPIs essentiels (25 min)
- Outils d'analyse (30 min)
- Optimisation continue (35 min)
- Cas d'études avancés (40 min)

#### 🚀 Module 5 : Techniques avancées
- Automatisation (45 min)
- Intégrations avancées (40 min)
- Stratégies d'experts (50 min)
- Certification finale (30 min)

**Total par formation** : ~8-10 heures de contenu

---

## 🗄️ Structure de Base de Données

### Tables Créées

```sql
service_categories      -- 18 catégories de services
blog_articles          -- Articles de blog
formations             -- Formations
formation_modules      -- Modules de formation (5 par formation)
formation_lessons      -- Leçons (4 par module = 20 par formation)
formation_enrollments  -- Inscriptions utilisateurs
blog_comments          -- Commentaires d'articles
tags                   -- Tags pour articles
article_tags           -- Liaison articles-tags
```

---

## 🚀 Installation et Utilisation

### Étape 1 : Créer les tables

```bash
# Exécuter le script SQL
mysql -u root digita_marketing < database/create_blog_formations.sql
```

Ou via phpMyAdmin :
1. Ouvrir phpMyAdmin
2. Sélectionner la base `digita_marketing`
3. Onglet "SQL"
4. Copier-coller le contenu de `database/create_blog_formations.sql`
5. Cliquer sur "Exécuter"

### Étape 2 : Générer le contenu

```bash
# Générer tous les articles et formations
php scripts/generate_content.php
```

**Options** :
```php
// Dans le fichier generate_content.php, ligne finale :

// Générer tout (300+ services)
$generator->generateAll();

// OU limiter pour tester (ex: 10 premiers services)
$generator->generateAll(10);
```

### Étape 3 : Vérifier la génération

Le script affiche :
```
🚀 Démarrage de la génération de contenu...

✅ 300+ services détectés

✅ Article créé : Community management
✅ Formation créée : Formation Community management
✅ Article créé : Création et planification de contenu
✅ Formation créée : Formation Création et planification de contenu
...

========================================
✅ Génération terminée !
📝 Articles créés : 300+
🎓 Formations créées : 300+
========================================
```

---

## 📁 Fichiers Créés

### Scripts
- `database/create_blog_formations.sql` - Structure BDD
- `scripts/generate_content.php` - Générateur de contenu

### Modèles
- `app/Models/Article.php` - Gestion des articles
- `app/Models/Formation.php` - Gestion des formations

### Documentation
- `GENERATION_CONTENU.md` - Ce fichier

---

## 🎨 Personnalisation

### Modifier le Template d'Article

Éditer la méthode `generateArticleContent()` dans `scripts/generate_content.php` :

```php
private function generateArticleContent($service) {
    $name = $service['name'];
    
    $content = "# {$name} : Guide Complet\n\n";
    // Ajouter vos sections personnalisées ici
    
    return $content;
}
```

### Modifier la Structure de Formation

Éditer la méthode `generateFormationModules()` dans `scripts/generate_content.php` :

```php
private function generateFormationModules($service) {
    return [
        [
            'title' => "Votre module personnalisé",
            'description' => "Description",
            'lessons' => [
                ['title' => "Leçon 1", 'duration' => 30, 'is_free' => true],
                // Ajouter plus de leçons
            ]
        ],
        // Ajouter plus de modules
    ];
}
```

---

## 📊 Statistiques

### Contenu Généré

| Type | Quantité | Détails |
|------|----------|---------|
| **Services** | 300+ | Tous les services du site |
| **Articles** | 300+ | 1 article par service |
| **Formations** | 300+ | 1 formation par service |
| **Modules** | 1500+ | 5 modules par formation |
| **Leçons** | 6000+ | 20 leçons par formation |

### Durée Totale

- **Par formation** : ~8-10 heures
- **Total formations** : ~3000 heures de contenu
- **Leçons gratuites** : 2 par formation (600+ leçons gratuites)

---

## 🔧 Fonctionnalités des Modèles

### Article.php

```php
$article = new Article();

// Récupérer tous les articles
$articles = $article->getAllPublished(20, 0);

// Récupérer un article par slug
$article = $article->getBySlug('community-management');

// Rechercher
$results = $article->search('SEO');

// Articles populaires
$popular = $article->getPopular(5);

// Par catégorie
$articles = $article->getByCategory('reseaux-sociaux');
```

### Formation.php

```php
$formation = new Formation();

// Récupérer toutes les formations
$formations = $formation->getAllPublished(20, 0);

// Formation complète avec modules et leçons
$fullFormation = $formation->getFullFormation('formation-seo');

// Inscrire un utilisateur
$formation->enroll($userId, $formationId);

// Vérifier l'inscription
$isEnrolled = $formation->isEnrolled($userId, $formationId);

// Formations populaires
$popular = $formation->getPopular(6);
```

---

## 🎯 Prochaines Étapes

### À Faire

- [ ] Créer les contrôleurs (BlogController, FormationController)
- [ ] Créer les vues (liste articles, détail article, liste formations, détail formation)
- [ ] Ajouter les routes dans `public/index.php`
- [ ] Créer la page d'administration pour gérer le contenu
- [ ] Ajouter un système de commentaires
- [ ] Ajouter un système de notation pour les formations
- [ ] Créer un système de progression pour les formations
- [ ] Ajouter des certificats de fin de formation

### Améliorations Possibles

- 🎨 Générer des images pour chaque article (via IA)
- 🎥 Ajouter des vidéos d'introduction
- 📝 Enrichir le contenu avec des exemples réels
- 🏷️ Ajouter des tags automatiques
- 🔗 Créer des liens entre articles connexes
- 📧 Système de newsletter automatique
- 💬 Intégration chatbot pour répondre aux questions

---

## ⚠️ Important

### Avant de Générer en Production

1. ✅ **Tester** sur une base de données de développement
2. ✅ **Vérifier** que les catégories sont bien créées
3. ✅ **Sauvegarder** la base de données
4. ✅ **Limiter** le nombre de services pour tester (ex: 10)
5. ✅ **Vérifier** le résultat avant de tout générer

### Régénération

Si vous voulez régénérer le contenu :

```sql
-- Supprimer tout le contenu généré
TRUNCATE TABLE formation_lessons;
TRUNCATE TABLE formation_modules;
TRUNCATE TABLE formation_enrollments;
TRUNCATE TABLE formations;
TRUNCATE TABLE article_tags;
TRUNCATE TABLE blog_comments;
TRUNCATE TABLE blog_articles;

-- Puis relancer le script
php scripts/generate_content.php
```

---

## 📞 Support

Pour toute question ou problème :
- 📧 Email : contact@digita-marketing.com
- 📚 Documentation : `/docs`

---

## ✅ Checklist de Déploiement

- [ ] Tables créées dans la base de données
- [ ] Script de génération exécuté avec succès
- [ ] Articles visibles dans la base de données
- [ ] Formations visibles dans la base de données
- [ ] Modules et leçons créés
- [ ] Contrôleurs créés
- [ ] Vues créées
- [ ] Routes ajoutées
- [ ] Tests effectués
- [ ] Contenu vérifié et validé

---

© 2025 Digita Marketing - Système de Génération de Contenu v1.0
