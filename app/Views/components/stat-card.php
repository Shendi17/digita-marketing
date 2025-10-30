<?php
/**
 * Composant : Carte de statistique
 * Usage: include 'components/stat-card.php';
 */

$icon = $icon ?? 'bi-graph-up';
$title = $title ?? 'Statistique';
$value = $value ?? '0';
$badge = $badge ?? null;
$footer = $footer ?? null;
$color = $color ?? 'primary';
?>

<div class="stat-card">
    <div class="stat-icon bg-<?= $color ?>-subtle">
        <i class="bi <?= $icon ?> text-<?= $color ?>"></i>
    </div>
    <div class="stat-content">
        <div class="stat-label"><?= htmlspecialchars($title) ?></div>
        <div class="stat-value"><?= htmlspecialchars($value) ?></div>
        <?php if ($badge): ?>
            <div class="stat-details">
                <?= $badge ?>
            </div>
        <?php endif; ?>
        <?php if ($footer): ?>
            <div class="stat-footer">
                <small class="text-muted"><?= $footer ?></small>
            </div>
        <?php endif; ?>
    </div>
</div>
