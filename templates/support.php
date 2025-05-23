<?php
$pageTitle = 'Support';
$extraCss = ['/digita-marketing/assets/css/support.css'];
ob_start();
?>
<section class="py-5">
  <div class="container">
    <h1 class="display-4 mb-4">Support</h1>
    <p class="lead">Nous pouvons vous aider. Retrouvez ici nos ressources d'assistance, FAQ ou contactez notre équipe support.</p>
    <ul>
      <li>FAQ et documentation</li>
      <li>Assistance technique par email</li>
      <li>Support personnalisé sur demande</li>
    </ul>
  </div>
</section>
<section id="ecommerce-team" class="py-5 bg-alt" data-aos="fade-right">
  <div class="container">
    <h2 class="section-title-icon fw-bold d-flex align-items-center justify-content-center mb-4">
      <i class="fas fa-shopping-cart me-2"></i>L'équipe E-Commerce
    </h2>
    <span class="section-title-separator"></span>
    <!-- Ajoute ici le contenu de la section équipe e-commerce -->
  </div>
</section>
<?php $content = ob_get_clean(); require __DIR__ . '/layout.php'; ?>
