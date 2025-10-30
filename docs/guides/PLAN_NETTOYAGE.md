# 🧹 Plan de Nettoyage du Projet

## 📊 Analyse Actuelle

**Fichiers MD à la racine** : ~120 fichiers  
**Status** : ⚠️ Trop de documentation obsolète

---

## 🗂️ NOUVELLE STRUCTURE PROPOSÉE

```
digita-marketing/
├── docs/
│   ├── archives/              # Anciens fichiers MD (historique)
│   ├── audits/                # Audits (MVC, Responsive, Conflits)
│   ├── corrections/           # Historique des corrections
│   ├── migrations/            # Docs de migration MVC
│   └── guides/                # Guides actuels et utiles
│
├── scripts/
│   ├── migration/             # Scripts de migration BDD
│   └── utilities/             # Scripts utilitaires
│
├── public/
│   └── (nettoyer scripts temporaires)
│
└── (fichiers essentiels à la racine)
    ├── README.md
    ├── CHANGELOG.md
    ├── .env
    ├── .gitignore
    └── composer.json
```

---

## 🗑️ FICHIERS À SUPPRIMER

### Scripts Temporaires (public/)
```
❌ migrate-article-slug.php
❌ link-all-formations.php
❌ create-missing-articles.php
❌ create-last-2-articles.php
```

### Scripts PowerShell Obsolètes (racine)
```
❌ create-catalogue-view.ps1
❌ create-views.ps1
❌ setup_git.bat
```

### Fichiers Texte Obsolètes
```
❌ Amélios
❌ SUCCESS.txt
❌ INSTALLATION_COMPLETE.txt
❌ VERSION_2.1_COMPLETE.txt
❌ PROJECT_STRUCTURE.txt
```

---

## 📁 FICHIERS À DÉPLACER

### → docs/audits/
```
✓ AUDIT_MVC_BLOG.md
✓ AUDIT_MVC_STYLES.md
✓ AUDIT_RESPONSIVE.md
✓ AUDIT_CONFLITS_STYLES.md
```

### → docs/guides/
```
✓ README.md (garder à la racine + copie)
✓ QUICK_START.md
✓ FEATURES.md
✓ GUIDE_EXECUTION.md
✓ INDEX_DOCUMENTATION.md
✓ OPTIMISATION_COMPLETE.md
```

### → docs/migrations/
```
✓ MIGRATION_MVC_*.md (tous)
✓ FINALISATION_MIGRATION_MVC.md
✓ RECAPITULATIF_MIGRATION_MVC_COMPLETE.md
✓ RESUME_FINAL_MIGRATION.md
✓ STRUCTURE_MVC_*.md
✓ EXECUTER_MIGRATION_BDD.md
```

### → docs/corrections/
```
✓ CORRECTION_*.md (tous les ~50 fichiers)
✓ RESOLUTION_*.md
✓ SOLUTION_*.md
✓ NETTOYAGE_*.md
```

### → docs/archives/
```
✓ Tous les autres fichiers MD obsolètes
```

---

## ✅ FICHIERS À GARDER À LA RACINE

```
✓ README.md
✓ CHANGELOG.md
✓ .env
✓ .env.example
✓ .gitignore
✓ .htaccess
✓ composer.json
✓ phpunit.xml
```

---

## 🎯 ACTIONS

1. Créer structure docs/
2. Déplacer fichiers MD
3. Supprimer scripts temporaires
4. Supprimer fichiers obsolètes
5. Mettre à jour README.md
6. Créer INDEX.md dans docs/
