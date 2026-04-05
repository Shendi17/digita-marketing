# DIGITA MARKETING — Stratégie Globale d'Optimisation & Croissance

**Date :** 10 Février 2026  
**Version :** 1.0  
**Auteur :** Équipe Digita  

---

## 1. VISION GLOBALE

Transformer Digita Marketing d'un site vitrine avec contenu de démo en une **plateforme SaaS leader** dans le marketing digital, l'automatisation et l'IA à La Réunion et dans l'Océan Indien.

### Écosystème à 2 piliers

```
┌─────────────────────────────────────────────────────────┐
│                    DIGITA MARKETING                      │
│         (PHP/MVC — Site public + Admin CMS)              │
│                                                          │
│  ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌────────────┐ │
│  │ Blog SEO │ │Formations│ │ Boutique │ │Espace Client│ │
│  └──────────┘ └──────────┘ └──────────┘ └────────────┘ │
│                        │                                 │
│                   API REST / Webhooks                    │
│                        │                                 │
├────────────────────────┼────────────────────────────────┤
│                    WEBOX MULTI-IA                        │
│          (Python/FastAPI — Moteur IA Backend)            │
│                                                          │
│  ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌────────────┐ │
│  │Website   │ │Content   │ │Agents IA │ │ Génération  │ │
│  │Builder   │ │Engine    │ │Spécialisés│ │ Multi-Média│ │
│  └──────────┘ └──────────┘ └──────────┘ └────────────┘ │
└─────────────────────────────────────────────────────────┘
```

**Digita** = Vitrine publique, CMS, vente, relation client  
**Webox** = Moteur IA, génération de contenu, création de projets clients, automatisation  

---

## 2. ARCHITECTURE PONT DIGITA ↔ WEBOX

### Pourquoi un pont plutôt que tout dans Digita ?

| Critère | Tout dans Digita | Pont Digita ↔ Webox |
|---------|-----------------|---------------------|
| **Temps de dev** | 6+ mois | 2-3 semaines (Webox existe déjà) |
| **Capacités IA** | Limitées (1 API OpenAI) | 14 APIs IA, 20+ modèles |
| **Génération média** | À construire | Images, vidéos, audio, code déjà prêts |
| **Website Builder** | À construire | Déjà fonctionnel dans Webox |
| **Maintenance** | 1 monolithe complexe | 2 projets spécialisés |
| **Scalabilité** | Limitée | Chaque pilier scale indépendamment |

### Communication entre les 2 projets

```
DIGITA (PHP)                          WEBOX (Python/FastAPI)
─────────────                         ─────────────────────
Admin CMS                             
  │                                   
  ├─ POST /api/content/generate ──────► Content Engine
  │  {article_id, keywords, tone}      │ Génère contenu SEO
  │                                    │ Génère images
  │  ◄── {content, images, meta} ──────┘
  │                                   
  ├─ POST /api/website/create ────────► Website Builder IA
  │  {client_brief, template}          │ Génère le site
  │                                    │ Déploie automatiquement
  │  ◄── {project_url, files} ────────┘
  │                                   
  ├─ POST /api/formation/enrich ──────► LMS + Content Engine
  │  {formation_id, topics}            │ Génère modules
  │                                    │ Génère vidéos/quiz
  │  ◄── {modules, lessons, media} ───┘
  │                                   
  └─ POST /api/agent/task ────────────► Agents IA
     {task_type, data}                 │ Exécute la tâche
                                       │ Multi-agents si besoin
     ◄── {result, report} ────────────┘
```

### Implémentation technique du pont

**Côté Digita (PHP)** — Nouveau service `WeboxBridge` :
- Appels HTTP vers l'API Webox (localhost:8000 en dev, URL dédiée en prod)
- Authentification par API Key partagée
- File d'attente pour les tâches longues (génération vidéo, etc.)
- Webhooks pour recevoir les résultats asynchrones

**Côté Webox (Python)** — Nouveaux endpoints dédiés Digita :
- `/api/digita/content/generate` — Génération de contenu SEO
- `/api/digita/website/create` — Création de site client
- `/api/digita/formation/enrich` — Enrichissement de formations
- `/api/digita/media/generate` — Génération d'images/vidéos
- `/api/digita/seo/analyze` — Analyse SEO d'une page

---

## 3. LES 7 COUCHES D'OPTIMISATION

### COUCHE 1 — CMS Admin Complet (Semaine 1-2)

**Objectif :** Pouvoir créer/éditer articles et formations depuis l'admin en ligne.

#### 1.1 Éditeur d'articles
- Éditeur WYSIWYG (TinyMCE 6 ou Quill.js)
- Upload d'images avec drag & drop
- Champs SEO : meta title, meta description, keywords, slug
- Preview en temps réel
- Gestion des catégories et tags
- Statuts : brouillon, publié, archivé
- Planification de publication

#### 1.2 Éditeur de formations
- Gestion des modules (drag & drop pour réordonner)
- Gestion des leçons par module
- Upload de vidéos (YouTube/Vimeo embed ou upload direct)
- Éditeur de contenu de leçon (WYSIWYG)
- Gestion des prix et niveaux
- Preview de la formation

#### 1.3 Bibliothèque de médias
- Upload centralisé d'images
- Redimensionnement automatique (thumbnail, medium, large)
- Optimisation WebP automatique
- Organisation par dossiers
- Recherche par nom/tag

#### 1.4 Routes admin à créer
```
GET  /admin/articles              — Liste des articles
GET  /admin/articles/new          — Formulaire création
POST /admin/articles/store        — Sauvegarder article
GET  /admin/articles/edit/:id     — Formulaire édition
POST /admin/articles/update/:id   — Mettre à jour
POST /admin/articles/delete/:id   — Supprimer

GET  /admin/formations            — Liste des formations
GET  /admin/formations/new        — Formulaire création
POST /admin/formations/store      — Sauvegarder formation
GET  /admin/formations/edit/:id   — Formulaire édition
POST /admin/formations/update/:id — Mettre à jour

POST /admin/media/upload          — Upload média
GET  /admin/media                 — Bibliothèque
DELETE /admin/media/delete/:id    — Supprimer média
```

---

### COUCHE 2 — SEO Technique (Semaine 1-2, en parallèle)

**Objectif :** Optimiser le référencement technique pour un impact immédiat.

#### 2.1 Meta tags dynamiques
- `<title>` unique par page avec format : `{Titre} | Digita Marketing`
- `<meta name="description">` unique par page (max 160 caractères)
- `<meta name="keywords">` par article/formation
- Canonical URLs sur toutes les pages

#### 2.2 Open Graph & Twitter Cards
```html
<meta property="og:title" content="{titre}">
<meta property="og:description" content="{description}">
<meta property="og:image" content="{image_url}">
<meta property="og:url" content="{canonical_url}">
<meta property="og:type" content="article">
<meta name="twitter:card" content="summary_large_image">
```

#### 2.3 Schema.org (Données structurées)
- **Organization** — Sur toutes les pages
- **Article** — Sur chaque article de blog
- **Course** — Sur chaque formation
- **BreadcrumbList** — Fil d'Ariane
- **FAQPage** — Sur les pages avec FAQ
- **LocalBusiness** — Pour le SEO local (La Réunion)

#### 2.4 Performance technique
- Robots.txt optimisé
- Sitemap XML dynamique (améliorer l'existant)
- Compression Gzip via .htaccess
- Cache navigateur (expires headers)
- Lazy loading des images
- Minification CSS/JS

#### 2.5 SEO On-Page
- Fil d'Ariane (breadcrumbs) sur toutes les pages
- URLs propres et descriptives (déjà en place)
- Balises H1/H2/H3 structurées
- Liens internes automatiques entre articles liés
- Temps de lecture estimé sur les articles

---

### COUCHE 3 — Contenu SEO Qualitatif via IA (Semaine 3-4)

**Objectif :** Transformer les 472 articles génériques en contenu SEO premium.

#### 3.1 Workflow de réécriture assistée par IA

```
Article existant (générique)
        │
        ▼
[Webox Content Engine]
        │
        ├─ Recherche de mots-clés (Perplexity API)
        ├─ Analyse des intentions de recherche
        ├─ Génération de structure H1/H2/H3 optimisée
        ├─ Rédaction de contenu unique (Claude/GPT-4)
        ├─ Génération d'images illustratives (DALL-E/Imagen)
        ├─ Création de tableaux comparatifs
        ├─ Génération de FAQ basées sur "People Also Ask"
        ├─ Génération de meta description
        │
        ▼
Article enrichi (dans l'éditeur CMS)
        │
        ▼
[Révision humaine] → Publication
```

#### 3.2 Structure type d'un article SEO premium

```markdown
# {H1 — Mot-clé principal}

[Image hero — générée par IA ou stock]
[Temps de lecture : X min]
[Dernière mise à jour : date]

## Table des matières (auto-générée)

## Introduction (200 mots)
- Accroche avec statistique ou question
- Contexte du sujet
- Promesse de l'article

## {H2 — Sous-thème 1}
[Image illustrative]
- Contenu détaillé (300-500 mots)
- Exemples concrets
- Données chiffrées

### {H3 — Point détaillé}
[Tableau comparatif si pertinent]

## {H2 — Sous-thème 2}
[Infographie ou schéma]
...

## FAQ (5-8 questions)
[Schema.org FAQPage]

## Conclusion + CTA
[Lien vers formation associée]
[Formulaire de contact]
```

#### 3.3 Priorité de réécriture
1. **Top 18 articles** (1 par catégorie) — Pages piliers
2. **Articles à fort potentiel SEO** — Mots-clés à volume élevé
3. **Articles liés aux formations payantes** — Tunnel de conversion
4. **Reste des articles** — Par lot de 20/semaine

---

### COUCHE 4 — Formations Réelles (Semaine 3-5)

**Objectif :** Transformer les formations placeholder en produits vendables.

#### 4.1 Structure d'une formation premium

```
Formation : "Maîtriser le SEO en 2026"
├── Module 1 : Les Fondamentaux (gratuit)
│   ├── Leçon 1 : Qu'est-ce que le SEO ? [Vidéo 10min + Texte]
│   ├── Leçon 2 : Comment Google fonctionne [Vidéo 15min + Infographie]
│   └── Quiz de validation
├── Module 2 : SEO On-Page (payant)
│   ├── Leçon 1 : Recherche de mots-clés [Vidéo + Outil interactif]
│   ├── Leçon 2 : Optimisation du contenu [Vidéo + Checklist PDF]
│   ├── Leçon 3 : Balises et structure [Vidéo + Exercice pratique]
│   └── Quiz + Exercice noté
├── Module 3 : SEO Technique (payant)
│   ├── ...
├── Module 4 : Netlinking (payant)
│   ├── ...
├── Module 5 : Projet Final
│   ├── Brief du projet
│   ├── Soumission
│   └── Certificat de complétion
```

#### 4.2 Génération de contenu de formation via Webox

```
Brief formation (admin Digita)
        │
        ▼
[Webox LMS + Content Engine]
        │
        ├─ Génération du plan de cours (Claude/GPT-4)
        ├─ Rédaction du contenu de chaque leçon
        ├─ Génération de slides/présentations
        ├─ Création de quiz et exercices
        ├─ Génération d'images pédagogiques
        ├─ Scripts vidéo (à enregistrer ou générer)
        │
        ▼
Formation structurée (dans l'éditeur CMS)
        │
        ▼
[Révision humaine] → Publication
```

#### 4.3 Fonctionnalités LMS à implémenter dans Digita
- Système de progression (leçons complétées)
- Quiz avec correction automatique
- Certificats PDF auto-générés
- Espace apprenant (mes formations, ma progression)
- Système de notation et avis
- Contenu verrouillé (paywall Stripe)

---

### COUCHE 5 — Monétisation & Tunnel de Vente (Semaine 4-6)

**Objectif :** Convertir le trafic en revenus.

#### 5.1 Tunnel de conversion

```
[Article SEO gratuit]
        │
        ▼
[CTA : "Formation complète disponible"]
        │
        ▼
[Landing page formation]
  - Vidéo de présentation
  - Programme détaillé
  - Témoignages
  - Garantie satisfait ou remboursé
  - Prix barré + offre limitée
        │
        ▼
[Leçons gratuites (Module 1)]
        │
        ▼
[Inscription / Paiement Stripe]
        │
        ▼
[Accès formation complète]
        │
        ▼
[Email de suivi automatique]
  - J+1 : Bienvenue
  - J+3 : Avez-vous commencé ?
  - J+7 : Progression
  - J+30 : Certificat + upsell
```

#### 5.2 Sources de revenus

| Source | Prix | Marge |
|--------|------|-------|
| **Formations en ligne** | 49€ - 497€ | 95% |
| **Packs de services** | 299€ - 2999€ | 70% |
| **Création de sites (via Webox)** | 499€ - 4999€ | 80% |
| **Abonnement mensuel** | 29€ - 99€/mois | 90% |
| **Consulting 1-to-1** | 150€/h | 100% |
| **Affiliation outils IA** | Variable | 20-50% |

---

### COUCHE 6 — Automatisation Projets Clients (Semaine 5-8)

**Objectif :** Automatiser la création et gestion de projets clients via Webox.

#### 6.1 Workflow de création de projet client

```
[Client remplit formulaire sur Digita]
  - Type de projet (site web, e-commerce, landing page)
  - Secteur d'activité
  - Couleurs et style préférés
  - Contenu (textes, images, logo)
  - Budget
        │
        ▼
[Digita envoie le brief à Webox via API]
        │
        ▼
[Webox Website Builder IA]
  - Sélection du template adapté
  - Génération du contenu (textes, images)
  - Personnalisation des couleurs et styles
  - Création des pages
  - Optimisation SEO automatique
  - Déploiement sur sous-domaine de test
        │
        ▼
[Notification admin Digita]
  - Preview du site généré
  - Corrections manuelles si nécessaire
  - Validation
        │
        ▼
[Livraison au client]
  - Déploiement sur domaine final
  - Formation d'utilisation
  - Support post-livraison
```

#### 6.2 Espace client dans Digita
- Dashboard client personnalisé
- Suivi de projet en temps réel
- Messagerie intégrée
- Factures et paiements
- Historique des projets
- Demande de modifications

#### 6.3 Gestion interne
- Pipeline de projets (Kanban)
- Attribution automatique des tâches
- Suivi du temps passé
- Rentabilité par projet
- Reporting automatisé

---

### COUCHE 7 — IA & Fonctionnalités Pro (Semaine 6-10)

**Objectif :** Fonctionnalités avancées pour se différencier.

#### 7.1 Chatbot IA intégré (AIService déjà prêt)
- Widget chat sur toutes les pages
- Réponses contextuelles basées sur le contenu du site
- Qualification automatique des leads
- Prise de RDV automatique
- Transfert vers humain si nécessaire

#### 7.2 Outils gratuits (lead magnets)
- Audit SEO gratuit (analyse d'URL)
- Générateur de meta descriptions
- Analyseur de concurrence
- Calculateur de ROI marketing
- Générateur de calendrier éditorial

#### 7.3 Dashboard Analytics avancé
- Trafic en temps réel
- Conversions par source
- Revenue par formation
- Taux de complétion des formations
- Score SEO global du site

---

## 4. CRÉATION SEMI-AUTOMATIQUE DE PROJETS CLIENTS

### Architecture détaillée

```
┌─────────────────────────────────────────────────┐
│              DIGITA MARKETING                    │
│                                                  │
│  [Formulaire Client]                             │
│       │                                          │
│       ▼                                          │
│  [ProjectController]                             │
│       │                                          │
│       ├─ Validation du brief                     │
│       ├─ Création du projet en BDD               │
│       ├─ Calcul du devis automatique             │
│       │                                          │
│       ▼                                          │
│  [WeboxBridge Service]                           │
│       │                                          │
│       ├─ POST webox.api/digita/website/create    │
│       │   {brief, template, style, content}      │
│       │                                          │
│       ▼                                          │
├───────┼─────────────────────────────────────────┤
│       │         WEBOX MULTI-IA                   │
│       │                                          │
│       ▼                                          │
│  [Website Builder IA]                            │
│       │                                          │
│       ├─ Agent Marketing → Analyse du brief      │
│       ├─ Agent Produit → Choix du template       │
│       ├─ Content Engine → Génération textes      │
│       ├─ DALL-E/Imagen → Génération images       │
│       ├─ Code Generator → Pages HTML/CSS/JS      │
│       ├─ SEO Agent → Optimisation                │
│       │                                          │
│       ▼                                          │
│  [Deployment Engine]                             │
│       │                                          │
│       ├─ Déploiement sur sous-domaine test       │
│       ├─ Webhook → Digita (projet prêt)          │
│       │                                          │
│       ▼                                          │
├───────┼─────────────────────────────────────────┤
│       │         DIGITA MARKETING                 │
│       │                                          │
│       ▼                                          │
│  [Admin reçoit notification]                     │
│       │                                          │
│       ├─ Preview du site généré                  │
│       ├─ Corrections manuelles                   │
│       ├─ Validation                              │
│       ├─ Livraison au client                     │
│       └─ Enregistrement dans projets clients     │
│                                                  │
└─────────────────────────────────────────────────┘
```

### Tables BDD à créer dans Digita

```sql
-- Projets clients
CREATE TABLE client_projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    project_type ENUM('website','ecommerce','landing','app') NOT NULL,
    title VARCHAR(255) NOT NULL,
    brief TEXT NOT NULL,
    status ENUM('draft','generating','review','revision','delivered','completed') DEFAULT 'draft',
    webox_project_id VARCHAR(100),
    preview_url VARCHAR(500),
    production_url VARCHAR(500),
    price DECIMAL(10,2),
    paid TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    delivered_at TIMESTAMP NULL,
    FOREIGN KEY (client_id) REFERENCES users(id)
);

-- Messages projet
CREATE TABLE project_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES client_projects(id)
);

-- Fichiers projet
CREATE TABLE project_files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    filename VARCHAR(255) NOT NULL,
    filepath VARCHAR(500) NOT NULL,
    filetype VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES client_projects(id)
);
```

---

## 5. DOSSIER KAP NUMÉRIQUE

### 5.1 Présentation du dispositif

Le **Kap Numérique** est une aide de la Région Réunion destinée à accompagner les entreprises réunionnaises dans leur transformation digitale. L'aide peut couvrir jusqu'à **50% des dépenses éligibles** (plafond variable selon le dispositif).

### 5.2 Structure du dossier de demande

#### A. Présentation de l'entreprise
- Raison sociale, SIRET, forme juridique
- Activité principale : Agence de marketing digital et formation
- Effectif actuel et prévisionnel
- Chiffre d'affaires actuel et prévisionnel

#### B. Description du projet
**Titre :** Plateforme SaaS de Marketing Digital, Formation et Automatisation par IA

**Résumé :**
Développement d'une plateforme numérique innovante combinant :
1. Un site vitrine et blog SEO pour l'acquisition de clients
2. Une plateforme de formations en ligne (LMS) pour la montée en compétences
3. Un système d'automatisation par IA pour la création de projets clients
4. Un espace client pour la gestion de projets digitaux

**Innovation :**
- Utilisation de l'IA générative (GPT-4, Claude, Gemini) pour la création semi-automatique de sites web
- Automatisation des processus de marketing digital
- Plateforme tout-en-un unique à La Réunion

#### C. Objectifs chiffrés

| Indicateur | Année 1 | Année 2 | Année 3 |
|-----------|---------|---------|---------|
| **Visiteurs/mois** | 5 000 | 15 000 | 50 000 |
| **Formations vendues** | 50 | 200 | 500 |
| **Projets clients** | 20 | 60 | 150 |
| **CA formations** | 15 000€ | 60 000€ | 150 000€ |
| **CA projets** | 30 000€ | 120 000€ | 300 000€ |
| **CA total** | 45 000€ | 180 000€ | 450 000€ |
| **Emplois créés** | 1 | 3 | 5 |

#### D. Plan d'investissement

| Poste | Montant HT | Détail |
|-------|-----------|--------|
| **Développement plateforme** | 15 000€ | CMS, LMS, espace client, API |
| **Hébergement & infra** | 3 000€/an | Serveurs, CDN, SSL, domaines |
| **APIs IA** | 2 400€/an | OpenAI, Anthropic, Google, etc. |
| **Marketing digital** | 5 000€ | SEO, publicité, contenu |
| **Formation équipe** | 2 000€ | Certifications, outils |
| **Design & UX** | 3 000€ | Maquettes, charte graphique |
| **Total** | **30 400€** | |

#### E. Calendrier de réalisation

| Phase | Période | Livrables |
|-------|---------|-----------|
| **Phase 1** | Mois 1-2 | CMS Admin + SEO technique |
| **Phase 2** | Mois 2-4 | Contenu SEO + Formations réelles |
| **Phase 3** | Mois 4-6 | Monétisation + Tunnel de vente |
| **Phase 4** | Mois 6-9 | Pont Webox + Projets clients auto |
| **Phase 5** | Mois 9-12 | IA avancée + Fonctionnalités pro |

#### F. Impact territorial
- Création d'emplois qualifiés dans le numérique à La Réunion
- Formation des entrepreneurs locaux au marketing digital
- Démocratisation de l'accès aux outils IA pour les TPE/PME réunionnaises
- Contribution à l'écosystème numérique de l'Océan Indien
- Réduction de la fracture numérique

### 5.3 Pièces à fournir
- [ ] Formulaire de demande Kap Numérique (site Région Réunion)
- [ ] Kbis de moins de 3 mois
- [ ] Pièce d'identité du dirigeant
- [ ] 3 derniers bilans comptables (ou prévisionnel si création)
- [ ] Devis des prestataires (développement, hébergement, etc.)
- [ ] Business plan / plan de financement
- [ ] RIB de l'entreprise
- [ ] Attestation de régularité fiscale et sociale

---

## 6. PLANNING D'IMPLÉMENTATION

### Sprint 1 (Semaine 1-2) — Fondations
- [ ] **CMS Admin** : Éditeur d'articles (WYSIWYG + upload images + meta SEO)
- [ ] **CMS Admin** : Éditeur de formations (modules + leçons)
- [ ] **CMS Admin** : Bibliothèque de médias
- [ ] **SEO** : Meta tags dynamiques sur toutes les pages
- [ ] **SEO** : Open Graph + Twitter Cards
- [ ] **SEO** : Schema.org (Organization, Article, Course)
- [ ] **SEO** : Robots.txt + amélioration sitemap
- [ ] **SEO** : Breadcrumbs

### Sprint 2 (Semaine 3-4) — Contenu
- [ ] **Pont Webox** : Service WeboxBridge (appels API)
- [ ] **Pont Webox** : Endpoints Digita dans Webox
- [ ] **Contenu** : Réécriture des 18 articles piliers via IA
- [ ] **Contenu** : Génération d'images pour les articles
- [ ] **Formations** : Enrichissement des 6 formations principales

### Sprint 3 (Semaine 5-6) — Monétisation
- [ ] **LMS** : Système de progression des leçons
- [ ] **LMS** : Quiz et évaluations
- [ ] **LMS** : Certificats PDF
- [ ] **Vente** : Landing pages formations
- [ ] **Vente** : Tunnel de conversion article → formation
- [ ] **Email** : Séquences automatiques post-achat

### Sprint 4 (Semaine 7-8) — Projets Clients
- [ ] **Projets** : Formulaire de brief client
- [ ] **Projets** : Intégration Website Builder Webox
- [ ] **Projets** : Espace client (dashboard, messagerie)
- [ ] **Projets** : Pipeline de gestion interne

### Sprint 5 (Semaine 9-10) — IA & Pro
- [ ] **IA** : Chatbot intégré sur le site
- [ ] **IA** : Outils gratuits (audit SEO, générateurs)
- [ ] **Analytics** : Dashboard avancé
- [ ] **Kap Numérique** : Finalisation et soumission du dossier

---

## 7. MÉTRIQUES DE SUCCÈS

| KPI | Objectif M+3 | Objectif M+6 | Objectif M+12 |
|-----|-------------|-------------|---------------|
| **Trafic organique** | 1 000/mois | 5 000/mois | 15 000/mois |
| **Positions top 10 Google** | 20 mots-clés | 100 mots-clés | 500 mots-clés |
| **Taux de conversion** | 1% | 2.5% | 5% |
| **Formations vendues** | 5/mois | 20/mois | 50/mois |
| **Projets clients** | 2/mois | 5/mois | 15/mois |
| **CA mensuel** | 1 500€ | 8 000€ | 25 000€ |
| **Score PageSpeed** | > 80 | > 90 | > 95 |

---

## 8. STACK TECHNIQUE FINAL

| Composant | Technologie | Rôle |
|-----------|------------|------|
| **Digita Frontend** | PHP MVC + Bootstrap 5 + TailwindCSS | Site public |
| **Digita Admin** | PHP MVC + TinyMCE + Dropzone.js | CMS |
| **Digita BDD** | MySQL 8 (OVH) | Données |
| **Webox Backend** | Python FastAPI | Moteur IA |
| **Webox BDD** | SQLite / PostgreSQL | Données IA |
| **APIs IA** | OpenAI, Anthropic, Google, Mistral, etc. | Génération |
| **Paiement** | Stripe + PayPal | Monétisation |
| **Email** | SMTP + templates | Communication |
| **Hébergement Digita** | OVH Mutualisé | Production |
| **Hébergement Webox** | VPS ou Cloud (à définir) | API IA |
| **CDN** | Cloudflare (gratuit) | Performance |
| **Monitoring** | Google Analytics + Search Console | Suivi |
