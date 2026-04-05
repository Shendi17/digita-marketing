<!-- Espace Client - Dashboard -->
<section class="client-dashboard" style="padding-top: 120px; padding-bottom: 60px;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-bold">Espace Client</h1>
                <p class="text-muted mb-0">Gérez vos projets et suivez leur avancement</p>
            </div>
            <a href="/projets/brief" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nouveau projet
            </a>
        </div>

        <?php if (!empty($_SESSION['success_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= htmlspecialchars($_SESSION['success_message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <!-- Stats rapides -->
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-6">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <div class="fs-2 fw-bold text-primary"><?= count($projects) ?></div>
                        <small class="text-muted">Projets total</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <div class="fs-2 fw-bold text-warning"><?= count($activeProjects) ?></div>
                        <small class="text-muted">En cours</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <div class="fs-2 fw-bold text-success"><?= count($completedProjects) ?></div>
                        <small class="text-muted">Terminés</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <div class="fs-2 fw-bold text-danger"><?= $unreadMessages ?></div>
                        <small class="text-muted">Messages non lus</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des projets -->
        <?php if (empty($projects)): ?>
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-folder2-open text-muted" style="font-size: 4rem;"></i>
                    <h4 class="mt-3">Aucun projet pour le moment</h4>
                    <p class="text-muted">Créez votre premier projet en décrivant votre besoin.</p>
                    <a href="/projets/brief" class="btn btn-primary btn-lg">
                        <i class="bi bi-plus-circle"></i> Créer un projet
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($projects as $project): ?>
                    <div class="col-md-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <span class="badge bg-secondary"><?= htmlspecialchars($types[$project['project_type']] ?? $project['project_type']) ?></span>
                                        <?php
                                        $statusColors = [
                                            'draft' => 'light', 'pending' => 'warning', 'generating' => 'info',
                                            'review' => 'primary', 'revision' => 'orange', 'approved' => 'success',
                                            'delivered' => 'success', 'completed' => 'dark', 'cancelled' => 'danger'
                                        ];
                                        $color = $statusColors[$project['status']] ?? 'secondary';
                                        ?>
                                        <span class="badge bg-<?= $color ?>"><?= htmlspecialchars($statuses[$project['status']] ?? $project['status']) ?></span>
                                    </div>
                                    <?php if ($project['unread_messages'] > 0): ?>
                                        <span class="badge bg-danger rounded-pill"><?= $project['unread_messages'] ?> <i class="bi bi-chat-dots"></i></span>
                                    <?php endif; ?>
                                </div>
                                
                                <h5 class="card-title fw-bold"><?= htmlspecialchars($project['title']) ?></h5>
                                <p class="text-muted small mb-2"><?= htmlspecialchars(mb_strimwidth($project['brief'], 0, 120, '...')) ?></p>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <?php if ($project['price'] > 0): ?>
                                            <span class="fw-bold text-primary"><?= number_format($project['price'], 2) ?> €</span>
                                        <?php endif; ?>
                                        <small class="text-muted ms-2">
                                            <i class="bi bi-calendar3"></i> <?= date('d/m/Y', strtotime($project['created_at'])) ?>
                                        </small>
                                    </div>
                                    <a href="/espace-client/projet/<?= $project['id'] ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Voir
                                    </a>
                                </div>
                            </div>
                            
                            <?php if (!empty($project['preview_url'])): ?>
                                <div class="card-footer bg-light">
                                    <a href="<?= htmlspecialchars($project['preview_url']) ?>" target="_blank" class="text-decoration-none small">
                                        <i class="bi bi-box-arrow-up-right"></i> Voir la preview
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
