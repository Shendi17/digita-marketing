<?php
$pageTitle = 'Tarifs';
$extraCss = ['/digita-marketing/assets/css/tarifs.css'];
ob_start();
?>
<section class="py-5">
  <div class="container">
    <h1 class="display-4 mb-4">Tarifs</h1>
    <p class="lead">Découvrez nos offres et choisissez la formule qui correspond à vos besoins.</p>
    <ul>
      <li>Pack Essentiel : Pour les besoins de base</li>
      <li>Pack Pro : Pour aller plus loin</li>
      <li>Pack Premium : Accompagnement sur-mesure</li>
    </ul>
    <p>Pour un devis personnalisé, contactez-nous directement.</p>
  </div>
</section>
<?php $content = ob_get_clean(); require __DIR__ . '/layout.php'; ?>
