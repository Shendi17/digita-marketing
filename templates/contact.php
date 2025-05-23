<?php
$pageTitle = 'Contact';
$extraCss = ['/digita-marketing/assets/css/contact.css'];
ob_start();
?>
<section id="management-contact" class="py-5 bg-white parallax" data-aos="fade-left">
  <div class="container">
    <h2 class="section-title-icon fw-bold d-flex align-items-center justify-content-center mb-4">
      <i class="fas fa-users me-2"></i>Contact Management Social
    </h2>
    <span class="section-title-separator"></span>
    <?php require_once __DIR__ . '/../includes/partials/contact.php'; ?>
  </div>
</section>
<?php $content = ob_get_clean(); require __DIR__ . '/layout.php'; ?>
