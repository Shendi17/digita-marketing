<?php
$pageTitle = 'Équipe';
$extraCss = ['/assets/css/team.css'];
ob_start();
?>
<!-- Ton contenu principal ici, sans header/footer ni style inline -->
<?php $content = ob_get_clean(); require __DIR__ . '/layout.php'; ?>
