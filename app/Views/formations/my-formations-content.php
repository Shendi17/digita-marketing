<section class="py-5">
    <div class="container">
        <h1 class="fw-bold mb-2"><i class="bi bi-mortarboard-fill text-primary"></i> Mes formations</h1>
        <p class="text-muted mb-4">Suivez votre progression et accédez à vos formations.</p>

        <!-- Messages flash -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle-fill"></i> <?= htmlspecialchars($_SESSION['success_message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if (empty($formations)): ?>
            <div class="text-center py-5">
                <i class="bi bi-journal-x display-1 text-muted"></i>
                <h4 class="mt-3">Aucune formation en cours</h4>
                <p class="text-muted">Explorez notre catalogue et inscrivez-vous à une formation.</p>
                <a href="/formations" class="btn btn-primary"><i class="bi bi-search"></i> Voir les formations</a>
            </div>
        <?php else: ?>
            <!-- Onglets -->
            <ul class="nav nav-tabs mb-4" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#enCours">
                        <i class="bi bi-play-circle"></i> En cours
                        <span class="badge bg-primary ms-1"><?= count(array_filter($formations, function($f) { return !$f['completed']; })) ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#terminees">
                        <i class="bi bi-check-circle"></i> Terminées
                        <span class="badge bg-success ms-1"><?= count(array_filter($formations, function($f) { return $f['completed']; })) ?></span>
                    </a>
                </li>
                <?php if (!empty($certificates)): ?>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#certificats">
                        <i class="bi bi-award"></i> Certificats
                        <span class="badge bg-warning text-dark ms-1"><?= count($certificates) ?></span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>

            <div class="tab-content">
                <!-- En cours -->
                <div class="tab-pane fade show active" id="enCours">
                    <div class="row g-4">
                        <?php foreach ($formations as $f): ?>
                            <?php if ($f['completed']) continue; ?>
                            <div class="col-lg-4 col-md-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <?php if (!empty($f['image_url'])): ?>
                                        <img src="<?= htmlspecialchars($f['image_url']) ?>" class="card-img-top" style="height: 160px; object-fit: cover;" alt="">
                                    <?php else: ?>
                                        <div class="card-img-top bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 160px;">
                                            <i class="bi bi-mortarboard display-4 text-primary"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <span class="badge bg-light text-dark mb-2"><?= htmlspecialchars($f['category_name'] ?? '') ?></span>
                                        <h5 class="card-title fw-bold"><?= htmlspecialchars($f['title']) ?></h5>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <small class="text-muted"><?= $f['completed_lessons'] ?? 0 ?> / <?= $f['total_lessons'] ?? 0 ?> leçons</small>
                                            <span class="fw-bold text-primary"><?= $f['percentage'] ?? 0 ?>%</span>
                                        </div>
                                        <div class="progress mb-3" style="height: 6px;">
                                            <div class="progress-bar bg-primary" style="width: <?= $f['percentage'] ?? 0 ?>%"></div>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-white border-0 pt-0">
                                        <a href="/formations/<?= htmlspecialchars($f['slug']) ?>/learn" class="btn btn-primary w-100">
                                            <i class="bi bi-play-fill"></i> Continuer
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Terminées -->
                <div class="tab-pane fade" id="terminees">
                    <div class="row g-4">
                        <?php 
                        $hasCompleted = false;
                        foreach ($formations as $f): 
                            if (!$f['completed']) continue;
                            $hasCompleted = true;
                        ?>
                            <div class="col-lg-4 col-md-6">
                                <div class="card border-0 shadow-sm h-100 border-success border-opacity-25">
                                    <?php if (!empty($f['image_url'])): ?>
                                        <img src="<?= htmlspecialchars($f['image_url']) ?>" class="card-img-top" style="height: 160px; object-fit: cover;" alt="">
                                    <?php else: ?>
                                        <div class="card-img-top bg-success bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 160px;">
                                            <i class="bi bi-trophy display-4 text-success"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="badge bg-success"><i class="bi bi-check-circle-fill"></i> Terminée</span>
                                            <small class="text-muted"><?= date('d/m/Y', strtotime($f['completed_at'])) ?></small>
                                        </div>
                                        <h5 class="card-title fw-bold"><?= htmlspecialchars($f['title']) ?></h5>
                                    </div>
                                    <div class="card-footer bg-white border-0 pt-0 d-flex gap-2">
                                        <a href="/formations/<?= $f['id'] ?>/certificate" class="btn btn-success btn-sm flex-fill">
                                            <i class="bi bi-award"></i> Certificat
                                        </a>
                                        <a href="/formations/<?= htmlspecialchars($f['slug']) ?>/learn" class="btn btn-outline-secondary btn-sm flex-fill">
                                            <i class="bi bi-arrow-repeat"></i> Revoir
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php if (!$hasCompleted): ?>
                            <div class="col-12 text-center py-4 text-muted">
                                <i class="bi bi-hourglass-split display-4"></i>
                                <p class="mt-2">Aucune formation terminée pour le moment.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Certificats -->
                <?php if (!empty($certificates)): ?>
                <div class="tab-pane fade" id="certificats">
                    <div class="row g-4">
                        <?php foreach ($certificates as $cert): ?>
                            <div class="col-lg-4 col-md-6">
                                <div class="card border-0 shadow-sm text-center p-4">
                                    <i class="bi bi-award-fill display-3 text-warning"></i>
                                    <h5 class="fw-bold mt-3"><?= htmlspecialchars($cert['formation_title']) ?></h5>
                                    <p class="text-muted small mb-1">Certificat N° <?= htmlspecialchars($cert['certificate_number']) ?></p>
                                    <p class="text-muted small">Délivré le <?= date('d/m/Y', strtotime($cert['issued_at'])) ?></p>
                                    <a href="/formations/<?= $cert['formation_id'] ?>/certificate" class="btn btn-warning btn-sm">
                                        <i class="bi bi-eye"></i> Voir le certificat
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
