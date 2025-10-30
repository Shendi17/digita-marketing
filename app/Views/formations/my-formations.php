<?php require_once __DIR__ . '/../../../includes/partials/header.php'; ?>
<?php require_once __DIR__ . '/../../../includes/partials/navbar.php'; ?>

<!-- Mes Formations -->
<section class="py-5">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Accueil</a></li>
                <li class="breadcrumb-item"><a href="/formations">Formations</a></li>
                <li class="breadcrumb-item active">Mes formations</li>
            </ol>
        </nav>
        
        <div class="row">
            <div class="col-12">
                <h1 class="display-5 fw-bold mb-4">
                    <i class="bi bi-mortarboard"></i> Mes Formations
                </h1>
                
                <?php if (empty($enrollments)): ?>
                    <!-- Aucune formation -->
                    <div class="text-center py-5">
                        <i class="bi bi-inbox empty-icon"></i>
                        <h3 class="mt-4 mb-3">Vous n'êtes inscrit à aucune formation</h3>
                        <p class="text-muted mb-4">Découvrez nos 382+ formations pour développer vos compétences</p>
                        <a href="/formations" class="btn btn-primary btn-lg">
                            <i class="bi bi-search"></i> Parcourir les formations
                        </a>
                    </div>
                <?php else: ?>
                    <!-- Statistiques -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card shadow-sm">
                                <div class="card-body text-center">
                                    <h3 class="text-primary mb-0"><?= count($enrollments) ?></h3>
                                    <small class="text-muted">Formations inscrites</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card shadow-sm">
                                <div class="card-body text-center">
                                    <?php
                                    $completed = array_filter($enrollments, function($e) { return $e['completed']; });
                                    ?>
                                    <h3 class="text-success mb-0"><?= count($completed) ?></h3>
                                    <small class="text-muted">Terminées</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card shadow-sm">
                                <div class="card-body text-center">
                                    <?php
                                    $inProgress = array_filter($enrollments, function($e) { return !$e['completed'] && $e['progress'] > 0; });
                                    ?>
                                    <h3 class="text-warning mb-0"><?= count($inProgress) ?></h3>
                                    <small class="text-muted">En cours</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card shadow-sm">
                                <div class="card-body text-center">
                                    <?php
                                    $avgProgress = count($enrollments) > 0 ? array_sum(array_column($enrollments, 'progress')) / count($enrollments) : 0;
                                    ?>
                                    <h3 class="text-info mb-0"><?= round($avgProgress) ?>%</h3>
                                    <small class="text-muted">Progression moyenne</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Liste des formations -->
                    <div class="row g-4">
                        <?php foreach ($enrollments as $enrollment): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card h-100 shadow-sm hover-lift">
                                    <div class="card-body">
                                        <!-- Badge statut -->
                                        <div class="mb-3">
                                            <?php if ($enrollment['completed']): ?>
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle"></i> Terminée
                                                </span>
                                            <?php elseif ($enrollment['progress'] > 0): ?>
                                                <span class="badge bg-warning">
                                                    <i class="bi bi-hourglass-split"></i> En cours
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">
                                                    <i class="bi bi-play-circle"></i> Non commencée
                                                </span>
                                            <?php endif; ?>
                                            
                                            <?php if ($enrollment['category_name']): ?>
                                                <span class="badge bg-primary ms-2">
                                                    <?= htmlspecialchars($enrollment['category_name']) ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <!-- Titre -->
                                        <h5 class="card-title mb-3">
                                            <a href="/formations/<?= $enrollment['slug'] ?>" class="text-dark text-decoration-none">
                                                <?= htmlspecialchars($enrollment['title']) ?>
                                            </a>
                                        </h5>
                                        
                                        <!-- Progression -->
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between mb-1">
                                                <small class="text-muted">Progression</small>
                                                <small class="fw-bold"><?= $enrollment['progress'] ?>%</small>
                                            </div>
                                            <div class="progress progress-thin">
                                                <div class="progress-bar <?= $enrollment['completed'] ? 'bg-success' : 'bg-primary' ?>" 
                                                     style="width: <?= $enrollment['progress'] ?>%">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Informations -->
                                        <div class="mb-3">
                                            <small class="text-muted d-block">
                                                <i class="bi bi-clock"></i> <?= $enrollment['duration_hours'] ?> heures
                                            </small>
                                            <small class="text-muted d-block">
                                                <i class="bi bi-calendar"></i> Inscrit le <?= date('d/m/Y', strtotime($enrollment['enrolled_at'])) ?>
                                            </small>
                                            <?php if ($enrollment['completed'] && $enrollment['completed_at']): ?>
                                                <small class="text-success d-block">
                                                    <i class="bi bi-check-circle"></i> Terminée le <?= date('d/m/Y', strtotime($enrollment['completed_at'])) ?>
                                                </small>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <!-- Actions -->
                                        <div class="d-grid gap-2">
                                            <a href="/formations/<?= $enrollment['slug'] ?>/learn" class="btn btn-primary">
                                                <?php if ($enrollment['completed']): ?>
                                                    <i class="bi bi-arrow-clockwise"></i> Revoir
                                                <?php elseif ($enrollment['progress'] > 0): ?>
                                                    <i class="bi bi-play-circle"></i> Continuer
                                                <?php else: ?>
                                                    <i class="bi bi-play-circle"></i> Commencer
                                                <?php endif; ?>
                                            </a>
                                            
                                            <?php if ($enrollment['completed']): ?>
                                                <a href="/certificat/<?= $enrollment['id'] ?>" class="btn btn-outline-success btn-sm">
                                                    <i class="bi bi-award"></i> Télécharger le certificat
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- CTA Découvrir plus -->
                    <div class="text-center mt-5">
                        <h4 class="mb-3">Envie d'apprendre plus ?</h4>
                        <a href="/formations" class="btn btn-outline-primary btn-lg">
                            <i class="bi bi-plus-circle"></i> Découvrir d'autres formations
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../../../includes/partials/footer.php'; ?>
