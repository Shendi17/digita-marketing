<?php
$pageTitle = 'Blog';
$extraCss = ['/digita-marketing/assets/css/blog.css'];
ob_start();
?>
<section id="logo" class="py-5 bg-light" data-aos="fade-down">
  <div class="container">
    <h2 class="section-title-icon fw-bold d-flex align-items-center justify-content-center mb-4">
      <i class="fas fa-user-tie me-2"></i>À propos
    </h2>
    <span class="section-title-separator"></span>
    <h2 class="mb-4 text-primary">Bienvenue chez Digita</h2>
    <p class="lead">Votre partenaire digital pour booster votre visibilité, votre image et votre chiffre d'affaires grâce à des solutions innovantes et personnalisées.</p>
    <ul class="fs-5">
      <li>Accompagnement sur-mesure pour entrepreneurs et PME</li>
      <li>Expertise en stratégie digitale, communication et design</li>
      <li>Équipe passionnée, créative et à l’écoute de vos besoins</li>
    </ul>
  </div>
</section>
<?php $content = ob_get_clean(); require __DIR__ . '/layout.php'; ?>
