# 🔧 Exécuter la Migration BDD - Article Slug

## 🎯 Objectif

Ajouter le champ `article_slug` à la table `formations` pour lier les formations aux articles de blog.

---

## ✅ Méthode 1 : Via phpMyAdmin (RECOMMANDÉ)

### Étape 1 : Ouvrir phpMyAdmin
```
1. Ouvrir le navigateur
2. Aller sur : http://localhost/phpmyadmin
3. Se connecter (généralement : root / pas de mot de passe)
```

### Étape 2 : Sélectionner la Base de Données
```
1. Dans le menu de gauche, cliquer sur votre base de données
   (probablement : digita_marketing ou similaire)
2. Cliquer sur l'onglet "SQL" en haut
```

### Étape 3 : Copier-Coller le SQL
```
1. Ouvrir le fichier :
   database/migrations/add_article_slug_to_formations.sql

2. Copier TOUT le contenu

3. Coller dans la zone de texte de phpMyAdmin

4. Cliquer sur "Exécuter" (bouton en bas à droite)
```

### Étape 4 : Vérifier les Résultats
```
Vous devriez voir :
✅ "Requête exécutée avec succès"
✅ Un tableau avec les formations et leurs articles liés
✅ Des statistiques (X formations avec article, Y sans)
```

---

## ✅ Méthode 2 : Via MySQL en Ligne de Commande

### Étape 1 : Ouvrir PowerShell
```powershell
# Aller dans le dossier du projet
cd C:\Users\Anthony\CascadeProjects\digita-marketing
```

### Étape 2 : Se Connecter à MySQL
```powershell
# Remplacer 'digita_marketing' par le nom de votre base
mysql -u root -p digita_marketing
```

### Étape 3 : Exécuter le Fichier SQL
```sql
-- Dans MySQL
SOURCE database/migrations/add_article_slug_to_formations.sql;
```

### Étape 4 : Quitter
```sql
EXIT;
```

---

## ✅ Méthode 3 : Via un Script PHP

### Créer un fichier temporaire
```php
<?php
// public/migrate.php (À SUPPRIMER APRÈS UTILISATION)

require_once __DIR__ . '/../config/database.php';

$db = Database::getInstance();

// Lire le fichier SQL
$sql = file_get_contents(__DIR__ . '/../database/migrations/add_article_slug_to_formations.sql');

// Séparer les requêtes
$queries = array_filter(
    array_map('trim', explode(';', $sql)),
    function($query) {
        return !empty($query) && !preg_match('/^--/', $query);
    }
);

// Exécuter chaque requête
foreach ($queries as $query) {
    try {
        $db->query($query);
        echo "✅ OK: " . substr($query, 0, 50) . "...<br>";
    } catch (Exception $e) {
        echo "❌ Erreur: " . $e->getMessage() . "<br>";
    }
}

echo "<br><strong>Migration terminée !</strong>";
?>
```

### Exécuter
```
1. Créer le fichier public/migrate.php
2. Aller sur : http://digita-marketing.local/migrate.php
3. Vérifier les résultats
4. SUPPRIMER le fichier migrate.php (sécurité)
```

---

## 🔍 Vérification Après Migration

### Vérifier que la Colonne Existe
```sql
DESCRIBE formations;
```

**Résultat attendu** :
```
+---------------+--------------+------+-----+---------+
| Field         | Type         | Null | Key | Default |
+---------------+--------------+------+-----+---------+
| id            | int(11)      | NO   | PRI | NULL    |
| slug          | varchar(255) | NO   | UNI | NULL    |
| article_slug  | varchar(255) | YES  | MUL | NULL    | ← Nouveau
| title         | varchar(255) | NO   |     | NULL    |
| ...           | ...          | ...  | ... | ...     |
+---------------+--------------+------+-----+---------+
```

### Vérifier les Liens Créés
```sql
SELECT 
    f.title AS formation,
    f.article_slug,
    a.title AS article
FROM formations f
LEFT JOIN blog_articles a ON a.slug = f.article_slug
WHERE f.article_slug IS NOT NULL;
```

### Compter les Formations Liées
```sql
SELECT 
    COUNT(*) AS total,
    SUM(CASE WHEN article_slug IS NOT NULL THEN 1 ELSE 0 END) AS avec_article
FROM formations;
```

---

## 🧪 Tester le Résultat

### Test 1 : Page Formation avec Article
```
1. Aller sur : http://digita-marketing.local/formations/formation-cross-selling-upselling

2. Vérifier :
   ✅ Bouton "Lire l'article associé" visible
   ✅ Couleur bleu clair (outline-info)
   ✅ Icône file-text présente

3. Cliquer sur le bouton :
   ✅ Redirige vers /blog/cross-selling-upselling
   ✅ Article s'affiche
```

### Test 2 : Page Catégorie
```
1. Aller sur : http://digita-marketing.local/formations/categorie/e-commerce

2. Vérifier :
   ✅ Bouton "Article" sur certaines formations
   ✅ Pas de bouton sur les formations sans article
   ✅ Bouton "Voir détails" toujours présent
```

---

## 📊 Résultats Attendus

### Statistiques
```
Total formations : 50
Avec article : 15-20
Sans article : 30-35
Pourcentage lié : 30-40%
```

### Formations Liées (Exemples)
```
✅ Formation Cross-selling → Article Cross-selling
✅ Formation Templates → Article Templates
✅ Formation Bannières → Article Bannières
✅ Formation Couvertures → Article Couvertures
✅ Formation Stories → Article Stories
```

---

## ⚠️ En Cas de Problème

### Erreur : "Table doesn't exist"
```
→ Vérifier le nom de la base de données
→ Vérifier que vous êtes connecté à la bonne base
```

### Erreur : "Column already exists"
```
→ La colonne existe déjà
→ Passer directement aux UPDATE
```

### Erreur : "Foreign key constraint"
```
→ Vérifier que la table blog_articles existe
→ Vérifier les slugs des articles
```

### Aucun Lien Créé
```
→ Vérifier que les articles existent dans blog_articles
→ Vérifier les slugs (doivent correspondre exactement)
→ Exécuter les UPDATE manuellement un par un
```

---

## 🔄 Rollback (Annuler)

### Si Besoin d'Annuler
```sql
-- Supprimer l'index
DROP INDEX idx_article_slug ON formations;

-- Supprimer la colonne
ALTER TABLE formations DROP COLUMN article_slug;
```

---

## 📝 Checklist

```
□ Sauvegarder la base de données (export)
□ Ouvrir phpMyAdmin ou MySQL
□ Sélectionner la bonne base de données
□ Copier le contenu du fichier SQL
□ Exécuter le SQL
□ Vérifier les résultats (SELECT)
□ Tester une formation avec article
□ Tester une formation sans article
□ Vérifier la page catégorie
□ Supprimer migrate.php si créé
```

---

**Date** : 30 Octobre 2025 - 14:26
**Version** : 72.0 - Migration BDD Article Slug

🎯 **Fichier SQL prêt dans : database/migrations/add_article_slug_to_formations.sql**

---

## 🚀 EXÉCUTEZ MAINTENANT

```
1. Ouvrir phpMyAdmin : http://localhost/phpmyadmin
2. Sélectionner la base de données
3. Onglet "SQL"
4. Copier-coller le contenu de :
   database/migrations/add_article_slug_to_formations.sql
5. Cliquer "Exécuter"
6. Vérifier les résultats
7. Tester : http://digita-marketing.local/formations/formation-cross-selling-upselling
```

Le bouton "Lire l'article" apparaîtra immédiatement ! 🎉
