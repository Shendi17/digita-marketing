<!-- SECTION SERVICES -->
{{ include('partials/services/videos') }}
<div class="separator"></div>

{{ include('partials/services/tunnel') }}
<div class="separator"></div>

{{ include('partials/services/vitrine') }}
<div class="separator"></div>

{{ include('partials/services/ecommerce') }}
<div class="separator"></div>

{{ include('partials/services/management') }}
<div class="separator"></div>

{{ include('partials/services/publicite') }}
<div class="separator"></div>

{{ include('partials/services/ia') }}
```

Et voici les fichiers à créer dans le dossier `partials/services/` :

**videos.php**
```
<!-- SECTION VIDEOS -->
<section id="videos" class="scroll-offset py-5 bg-white parallax" style="background-image:url('/digita-marketing/assets/images/hero-bg.svg'); background-position:center 80px;" data-aos="fade-right">
  <div class="container">
    <h2 class="section-title-icon fw-bold d-flex align-items-center justify-content-center mb-4" style="color:#2563eb;font-size:2.1rem;gap:0.5em;">
      <i class="fas fa-video me-2" style="color:#2563eb;"></i>Vidéos
    </h2>
    <span class="section-title-separator"></span>
    <p class="lead">Nous produisons des vidéos captivantes pour donner vie à votre marque : présentation d’entreprise, interviews, tutoriels, animations motion design, teasers réseaux sociaux…</p>
    <ul>
      <li>Scénarisation, tournage et montage professionnel</li>
      <li>Animations et habillages graphiques sur-mesure</li>
      <li>Optimisation pour YouTube, Facebook, Instagram, TikTok</li>
      <li>Gestion des sous-titres, formats courts, reels, stories</li>
    </ul>
  </div>
</section>
```

**tunnel.php**
```
<!-- SECTION TUNNEL DE VENTE -->
<section id="tunnel" class="scroll-offset py-5 bg-alt" data-aos="fade-left">
  <div class="container">
    <h2 class="section-title-icon fw-bold d-flex align-items-center justify-content-center mb-4" style="color:#FFD700;font-size:2.1rem;gap:0.5em;">
      <i class="fas fa-funnel-dollar me-2" style="color:#FFD700;"></i>Tunnel De Vente
    </h2>
    <span class="section-title-separator"></span>
    <p class="lead">Augmentez vos conversions grâce à des tunnels de vente optimisés : pages de capture, séquences emails, upsells, automatisations…</p>
    <ul>
      <li>Conception UX/UI orientée conversion</li>
      <li>Intégration d’outils d’emailing, CRM, automation</li>
      <li>Tests A/B et analyse des performances</li>
      <li>Accompagnement à la rédaction persuasive</li>
    </ul>
  </div>
</section>
```

**vitrine.php**
```
<!-- SECTION SITE VITRINE -->
<section id="vitrine" class="scroll-offset py-5 bg-white parallax" style="background-image:url('/digita-marketing/assets/images/hero-bg.svg'); background-position:center 180px;" data-aos="fade-up">
  <div class="container">
    <h2 class="section-title-icon fw-bold d-flex align-items-center justify-content-center mb-4" style="color:#2563eb;font-size:2.1rem;gap:0.5em;">
      <i class="fas fa-laptop-code me-2" style="color:#2563eb;"></i>Site Vitrine
    </h2>
    <span class="section-title-separator"></span>
    <p class="lead">Présentez votre activité avec un site élégant, rapide et responsive, pensé pour rassurer vos clients et valoriser votre image.</p>
    <ul>
      <li>Design moderne, adapté à votre identité</li>
      <li>Optimisation SEO et vitesse de chargement</li>
      <li>Intégration de formulaires, galeries, témoignages</li>
      <li>Accompagnement à la rédaction de vos contenus</li>
    </ul>
  </div>
</section>
```

**ecommerce.php**
```
<!-- SECTION SITE E-COMMERCE -->
<section id="ecommerce" class="scroll-offset py-5 bg-alt" data-aos="fade-right">
  <div class="container">
    <h2 class="section-title-icon fw-bold d-flex align-items-center justify-content-center mb-4" style="color:#FFD700;font-size:2.1rem;gap:0.5em;">
      <i class="fas fa-shopping-cart me-2" style="color:#FFD700;"></i>Site E-Commerce
    </h2>
    <span class="section-title-separator"></span>
    <p class="lead">Développez votre boutique en ligne sur-mesure : catalogue, paiement sécurisé, gestion des stocks, marketing automatisé…</p>
    <ul>
      <li>Solutions WooCommerce, Shopify, Prestashop…</li>
      <li>Responsive design et expérience utilisateur fluide</li>
      <li>Intégration de modules de paiement, livraison, avis clients</li>
      <li>Formation à la gestion de votre boutique</li>
    </ul>
  </div>
</section>
```

**management.php**
```
<!-- SECTION MANAGEMENT SOCIAL -->
<section id="management" class="scroll-offset py-5 bg-white parallax" style="background-image:url('/digita-marketing/assets/images/hero-bg.svg'); background-position:center 280px;" data-aos="fade-up">
  <div class="container">
    <h2 class="section-title-icon fw-bold d-flex align-items-center justify-content-center mb-4" style="color:#2563eb;font-size:2.1rem;gap:0.5em;">
      <i class="fas fa-users me-2" style="color:#2563eb;"></i>Management Social
    </h2>
    <span class="section-title-separator"></span>
    <p class="lead">Animez et développez votre communauté sur les réseaux sociaux avec des stratégies de contenu engageantes et une modération professionnelle.</p>
    <ul>
      <li>Création de planning éditorial et publications régulières</li>
      <li>Création de visuels, vidéos, stories, reels</li>
      <li>Gestion des interactions et modération</li>
      <li>Veille et reporting sur vos réseaux</li>
    </ul>
  </div>
</section>
```

**publicite.php**
```
<!-- SECTION PUBLICITÉ -->
<section id="publicite" class="scroll-offset py-5 bg-alt" data-aos="fade-left">
  <div class="container">
    <h2 class="section-title-icon fw-bold d-flex align-items-center justify-content-center mb-4" style="color:#FFD700;font-size:2.1rem;gap:0.5em;">
      <i class="fas fa-bullhorn me-2" style="color:#FFD700;"></i>Publicité
    </h2>
    <span class="section-title-separator"></span>
    <p class="lead">Touchez vos prospects au bon moment grâce à des campagnes publicitaires ciblées et performantes sur Google, Facebook, Instagram, LinkedIn…</p>
    <ul>
      <li>Stratégie et ciblage sur-mesure</li>
      <li>Création de visuels et textes accrocheurs</li>
      <li>Suivi des conversions et reporting détaillé</li>
      <li>Optimisation continue du ROI</li>
    </ul>
  </div>
</section>
```

**ia.php**
```
<!-- SECTION IA -->
<section id="ia" class="scroll-offset py-5 bg-white parallax" style="background-image:url('/digita-marketing/assets/images/hero-bg.svg'); background-position:center 380px;" data-aos="fade-up">
  <div class="container">
    <h2 class="section-title-icon fw-bold d-flex align-items-center justify-content-center mb-4" style="color:#FFD700;font-size:2.1rem;gap:0.5em;">
      <i class="fas fa-robot me-2" style="color:#FFD700;"></i>Intelligence Artificielle (IA)
    </h2>
    <span class="section-title-separator"></span>
    <p class="lead">L’Intelligence Artificielle révolutionne le marketing digital : automatisation, personnalisation, analyse prédictive, création de contenus…</p>
    <ul>
      <li>Chatbots intelligents pour l’assistance client 24/7</li>
      <li>Génération de visuels et textes par IA (images, slogans, posts…)</li>
      <li>Analyse automatique des données et recommandations</li>
      <li>Segmentation avancée et campagnes ultra-ciblées</li>
    </ul>
  </div>
</section>
