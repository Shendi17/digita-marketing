<?php
$pageTitle = 'Portfolio';
$extraCss = ['/digita-marketing/assets/css/portfolio.css'];
ob_start();
?>
<section id="vitrine-portfolio" class="py-5 bg-white" data-aos="fade-up">
  <div class="container">
    <h2 class="section-title-icon fw-bold d-flex align-items-center justify-content-center mb-4">
      <i class="fas fa-laptop-code me-2"></i>Portfolio
    </h2>
    <span class="section-title-separator"></span>
    <?php require_once __DIR__ . '/../includes/partials/portfolio.php'; ?>
  </div>
</section>
<?php $content = ob_get_clean(); require __DIR__ . '/layout.php'; ?>
