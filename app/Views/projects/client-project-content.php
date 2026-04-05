<!-- Détail Projet Client -->
<section class="client-project" style="padding-top: 120px; padding-bottom: 60px;">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/espace-client">Espace Client</a></li>
                <li class="breadcrumb-item active"><?= htmlspecialchars($project['title']) ?></li>
            </ol>
        </nav>

        <?php if (!empty($_SESSION['success_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= htmlspecialchars($_SESSION['success_message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error_message'])): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= htmlspecialchars($_SESSION['error_message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <div class="row g-4">
            <!-- Colonne principale -->
            <div class="col-lg-8">
                <!-- En-tête projet -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
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
                                <span class="badge bg-<?= $color ?> fs-6"><?= htmlspecialchars($statuses[$project['status']] ?? $project['status']) ?></span>
                            </div>
                            <small class="text-muted">Projet #<?= $project['id'] ?></small>
                        </div>
                        <h2 class="fw-bold"><?= htmlspecialchars($project['title']) ?></h2>
                        <p class="text-muted"><?= nl2br(htmlspecialchars($project['brief'])) ?></p>
                        
                        <?php if (!empty($project['preview_url'])): ?>
                            <a href="<?= htmlspecialchars($project['preview_url']) ?>" target="_blank" class="btn btn-outline-primary">
                                <i class="bi bi-box-arrow-up-right"></i> Voir la preview
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($project['production_url'])): ?>
                            <a href="<?= htmlspecialchars($project['production_url']) ?>" target="_blank" class="btn btn-success">
                                <i class="bi bi-globe"></i> Voir le site en ligne
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Messagerie -->
                <div class="card shadow-sm mb-4" id="messages">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-chat-dots"></i> Messagerie</h5>
                    </div>
                    <div class="card-body" style="max-height: 500px; overflow-y: auto;" id="messagesContainer">
                        <?php if (empty($project['messages'])): ?>
                            <p class="text-muted text-center py-3">Aucun message pour le moment.</p>
                        <?php else: ?>
                            <?php foreach ($project['messages'] as $msg): ?>
                                <div class="d-flex mb-3 <?= $msg['is_admin'] ? '' : 'flex-row-reverse' ?>">
                                    <div class="<?= $msg['is_admin'] ? 'me-3' : 'ms-3' ?>">
                                        <div class="rounded-circle bg-<?= $msg['is_admin'] ? 'primary' : 'success' ?> text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="bi bi-<?= $msg['is_admin'] ? 'headset' : 'person' ?>"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1" style="max-width: 75%;">
                                        <div class="card <?= $msg['is_admin'] ? 'bg-light' : 'bg-success bg-opacity-10' ?>">
                                            <div class="card-body py-2 px-3">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <strong class="small"><?= $msg['is_admin'] ? 'Digita Marketing' : htmlspecialchars($msg['user_name'] ?? 'Vous') ?></strong>
                                                    <small class="text-muted"><?= date('d/m H:i', strtotime($msg['created_at'])) ?></small>
                                                </div>
                                                <p class="mb-0"><?= nl2br(htmlspecialchars($msg['message'])) ?></p>
                                                <?php if (!empty($msg['attachment'])): ?>
                                                    <a href="<?= htmlspecialchars($msg['attachment']) ?>" target="_blank" class="small">
                                                        <i class="bi bi-paperclip"></i> Pièce jointe
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer">
                        <form action="/espace-client/projet/<?= $project['id'] ?>/message" method="POST" enctype="multipart/form-data">
                            <div class="input-group">
                                <input type="text" name="message" class="form-control" placeholder="Votre message..." required>
                                <label class="btn btn-outline-secondary" for="attachInput">
                                    <i class="bi bi-paperclip"></i>
                                </label>
                                <input type="file" name="attachment" id="attachInput" class="d-none">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Fichiers -->
                <?php if (!empty($project['files'])): ?>
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-folder"></i> Fichiers du projet</h5>
                        </div>
                        <div class="list-group list-group-flush">
                            <?php foreach ($project['files'] as $file): ?>
                                <a href="<?= htmlspecialchars($file['filepath']) ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="bi bi-file-earmark"></i>
                                        <?= htmlspecialchars($file['filename']) ?>
                                        <small class="text-muted ms-2"><?= htmlspecialchars($file['uploaded_by'] ?? '') ?></small>
                                    </div>
                                    <small class="text-muted"><?= date('d/m/Y', strtotime($file['created_at'])) ?></small>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Infos projet -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="bi bi-info-circle"></i> Informations</h6>
                    </div>
                    <div class="card-body">
                        <dl class="mb-0">
                            <dt class="text-muted small">Type</dt>
                            <dd><?= htmlspecialchars($types[$project['project_type']] ?? $project['project_type']) ?></dd>
                            
                            <dt class="text-muted small">Créé le</dt>
                            <dd><?= date('d/m/Y à H:i', strtotime($project['created_at'])) ?></dd>
                            
                            <?php if ($project['price'] > 0): ?>
                                <dt class="text-muted small">Devis</dt>
                                <dd class="fw-bold text-primary fs-5"><?= number_format($project['price'], 2) ?> €</dd>
                            <?php endif; ?>
                            
                            <dt class="text-muted small">Délai estimé</dt>
                            <dd><?= $project['estimated_days'] ?? '—' ?> jours</dd>
                            
                            <?php if (!empty($project['delivered_at'])): ?>
                                <dt class="text-muted small">Livré le</dt>
                                <dd class="text-success"><?= date('d/m/Y', strtotime($project['delivered_at'])) ?></dd>
                            <?php endif; ?>
                        </dl>
                    </div>
                </div>

                <!-- Historique des statuts -->
                <?php if (!empty($project['history'])): ?>
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="bi bi-clock-history"></i> Historique</h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                <?php foreach (array_slice($project['history'], 0, 10) as $h): ?>
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between">
                                            <strong class="small"><?= htmlspecialchars($statuses[$h['new_status']] ?? $h['new_status']) ?></strong>
                                            <small class="text-muted"><?= date('d/m H:i', strtotime($h['created_at'])) ?></small>
                                        </div>
                                        <?php if (!empty($h['note'])): ?>
                                            <small class="text-muted"><?= htmlspecialchars($h['note']) ?></small>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<script>
// Scroll auto vers le bas des messages
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('messagesContainer');
    if (container) container.scrollTop = container.scrollHeight;
});
</script>
