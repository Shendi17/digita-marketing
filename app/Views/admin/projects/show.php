<div class="container-fluid px-4 py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/admin/projects">Projets</a></li>
            <li class="breadcrumb-item active">Projet #<?= $project['id'] ?></li>
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
            <!-- En-tête -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="badge bg-secondary"><?= htmlspecialchars($types[$project['project_type']] ?? $project['project_type']) ?></span>
                            <?php
                            $sc = ['draft'=>'light','pending'=>'warning','generating'=>'info','review'=>'primary','revision'=>'secondary','approved'=>'success','delivered'=>'success','completed'=>'dark','cancelled'=>'danger'];
                            ?>
                            <span class="badge bg-<?= $sc[$project['status']] ?? 'secondary' ?> fs-6"><?= htmlspecialchars($statuses[$project['status']] ?? $project['status']) ?></span>
                            <?php if ($project['priority'] === 'urgent'): ?>
                                <span class="badge bg-danger">URGENT</span>
                            <?php elseif ($project['priority'] === 'high'): ?>
                                <span class="badge bg-warning text-dark">Priorité haute</span>
                            <?php endif; ?>
                        </div>
                        <span class="text-muted">#<?= $project['id'] ?></span>
                    </div>
                    <h2 class="fw-bold"><?= htmlspecialchars($project['title']) ?></h2>
                    <p class="mb-2"><strong>Client :</strong> <?= htmlspecialchars($project['client_name'] ?? $project['client_email']) ?> (<?= htmlspecialchars($project['client_email']) ?>)</p>
                    <p class="text-muted"><?= nl2br(htmlspecialchars($project['brief'])) ?></p>

                    <?php
                    $briefData = json_decode($project['brief_data'] ?? '{}', true);
                    if (!empty($briefData)):
                    ?>
                        <div class="bg-light rounded p-3 mt-3">
                            <h6 class="fw-bold mb-2">Détails du brief</h6>
                            <div class="row g-2 small">
                                <?php if (!empty($briefData['business_name'])): ?>
                                    <div class="col-md-6"><strong>Entreprise :</strong> <?= htmlspecialchars($briefData['business_name']) ?></div>
                                <?php endif; ?>
                                <?php if (!empty($briefData['business_type'])): ?>
                                    <div class="col-md-6"><strong>Secteur :</strong> <?= htmlspecialchars($briefData['business_type']) ?></div>
                                <?php endif; ?>
                                <?php if (!empty($briefData['target_audience'])): ?>
                                    <div class="col-md-6"><strong>Cible :</strong> <?= htmlspecialchars($briefData['target_audience']) ?></div>
                                <?php endif; ?>
                                <?php if (!empty($briefData['style'])): ?>
                                    <div class="col-md-6"><strong>Style :</strong> <?= htmlspecialchars($briefData['style']) ?></div>
                                <?php endif; ?>
                                <?php if (!empty($briefData['pages'])): ?>
                                    <div class="col-md-6"><strong>Pages :</strong> <?= (int)$briefData['pages'] ?></div>
                                <?php endif; ?>
                                <?php if (!empty($briefData['features'])): ?>
                                    <div class="col-12"><strong>Fonctionnalités :</strong> <?= htmlspecialchars(implode(', ', (array)$briefData['features'])) ?></div>
                                <?php endif; ?>
                                <?php if (!empty($briefData['existing_url'])): ?>
                                    <div class="col-12"><strong>Site existant :</strong> <a href="<?= htmlspecialchars($briefData['existing_url']) ?>" target="_blank"><?= htmlspecialchars($briefData['existing_url']) ?></a></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($project['preview_url'])): ?>
                        <a href="<?= htmlspecialchars($project['preview_url']) ?>" target="_blank" class="btn btn-outline-primary mt-3">
                            <i class="bi bi-box-arrow-up-right"></i> Preview
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($project['production_url'])): ?>
                        <a href="<?= htmlspecialchars($project['production_url']) ?>" target="_blank" class="btn btn-success mt-3">
                            <i class="bi bi-globe"></i> Production
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Messagerie -->
            <div class="card shadow-sm mb-4" id="messages">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <h5 class="mb-0"><i class="bi bi-chat-dots"></i> Messagerie client</h5>
                    <span class="badge bg-white text-primary"><?= count($project['messages']) ?></span>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;" id="msgContainer">
                    <?php if (empty($project['messages'])): ?>
                        <p class="text-muted text-center py-3">Aucun message.</p>
                    <?php else: ?>
                        <?php foreach ($project['messages'] as $msg): ?>
                            <div class="d-flex mb-3 <?= $msg['is_admin'] ? 'flex-row-reverse' : '' ?>">
                                <div class="<?= $msg['is_admin'] ? 'ms-3' : 'me-3' ?>">
                                    <div class="rounded-circle bg-<?= $msg['is_admin'] ? 'primary' : 'success' ?> text-white d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                        <i class="bi bi-<?= $msg['is_admin'] ? 'headset' : 'person' ?>"></i>
                                    </div>
                                </div>
                                <div style="max-width: 70%;">
                                    <div class="card <?= $msg['is_admin'] ? 'bg-primary bg-opacity-10' : 'bg-light' ?>">
                                        <div class="card-body py-2 px-3">
                                            <div class="d-flex justify-content-between mb-1">
                                                <strong class="small"><?= $msg['is_admin'] ? 'Admin' : htmlspecialchars($msg['user_name'] ?? 'Client') ?></strong>
                                                <small class="text-muted"><?= date('d/m H:i', strtotime($msg['created_at'])) ?></small>
                                            </div>
                                            <p class="mb-0 small"><?= nl2br(htmlspecialchars($msg['message'])) ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="card-footer">
                    <form action="/admin/projects/<?= $project['id'] ?>/message" method="POST">
                        <div class="input-group">
                            <input type="text" name="message" class="form-control" placeholder="Répondre au client..." required>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tâches -->
            <div class="card shadow-sm" id="tasks">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="mb-0"><i class="bi bi-check2-square"></i> Tâches</h5>
                    <span class="badge bg-secondary"><?= count($project['tasks']) ?></span>
                </div>
                <div class="card-body">
                    <?php if (!empty($project['tasks'])): ?>
                        <?php foreach ($project['tasks'] as $task): ?>
                            <div class="d-flex align-items-center mb-2 p-2 bg-light rounded">
                                <select class="form-select form-select-sm me-2" style="width: 130px;" onchange="updateTask(<?= $task['id'] ?>, this.value)">
                                    <option value="todo" <?= $task['status'] === 'todo' ? 'selected' : '' ?>>À faire</option>
                                    <option value="in_progress" <?= $task['status'] === 'in_progress' ? 'selected' : '' ?>>En cours</option>
                                    <option value="done" <?= $task['status'] === 'done' ? 'selected' : '' ?>>Fait</option>
                                </select>
                                <span class="<?= $task['status'] === 'done' ? 'text-decoration-line-through text-muted' : '' ?>"><?= htmlspecialchars($task['title']) ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    
                    <form action="/admin/projects/<?= $project['id'] ?>/task" method="POST" class="mt-3">
                        <div class="input-group">
                            <input type="text" name="task_title" class="form-control form-control-sm" placeholder="Nouvelle tâche..." required>
                            <button type="submit" class="btn btn-sm btn-outline-primary"><i class="bi bi-plus"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar admin -->
        <div class="col-lg-4">
            <!-- Actions -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-dark text-white">
                    <h6 class="mb-0"><i class="bi bi-gear"></i> Actions</h6>
                </div>
                <div class="card-body">
                    <!-- Changer le statut -->
                    <form action="/admin/projects/<?= $project['id'] ?>/status" method="POST" class="mb-3">
                        <label class="form-label fw-bold small">Changer le statut</label>
                        <select name="status" class="form-select form-select-sm mb-2">
                            <?php foreach ($statuses as $sKey => $sLabel): ?>
                                <option value="<?= $sKey ?>" <?= $project['status'] === $sKey ? 'selected' : '' ?>><?= $sLabel ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="text" name="note" class="form-control form-control-sm mb-2" placeholder="Note (optionnel)">
                        <button type="submit" class="btn btn-sm btn-primary w-100">Mettre à jour</button>
                    </form>

                    <!-- Prix -->
                    <form action="/admin/projects/<?= $project['id'] ?>/price" method="POST" class="mb-3">
                        <label class="form-label fw-bold small">Prix (€)</label>
                        <div class="input-group input-group-sm">
                            <input type="number" name="price" class="form-control" value="<?= $project['price'] ?>" step="0.01" min="0">
                            <button type="submit" class="btn btn-outline-primary"><i class="bi bi-check"></i></button>
                        </div>
                    </form>

                    <!-- Webox -->
                    <?php if (empty($project['webox_project_id'])): ?>
                        <form action="/admin/projects/<?= $project['id'] ?>/generate" method="POST">
                            <button type="submit" class="btn btn-sm btn-info w-100 <?= !$weboxConnected ? 'disabled' : '' ?>">
                                <i class="bi bi-robot"></i> Lancer génération Webox
                            </button>
                            <?php if (!$weboxConnected): ?>
                                <small class="text-danger d-block mt-1"><i class="bi bi-exclamation-triangle"></i> Webox non connecté</small>
                            <?php endif; ?>
                        </form>
                    <?php else: ?>
                        <div class="bg-light rounded p-2 small">
                            <strong>Webox ID :</strong> <?= htmlspecialchars($project['webox_project_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Infos -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-info-circle"></i> Informations</h6>
                </div>
                <div class="card-body small">
                    <dl class="mb-0">
                        <dt class="text-muted">Client</dt>
                        <dd><?= htmlspecialchars($project['client_name'] ?? $project['client_email']) ?></dd>
                        <dt class="text-muted">Créé le</dt>
                        <dd><?= date('d/m/Y H:i', strtotime($project['created_at'])) ?></dd>
                        <dt class="text-muted">Délai estimé</dt>
                        <dd><?= $project['estimated_days'] ?? '—' ?> jours</dd>
                        <?php if (!empty($project['started_at'])): ?>
                            <dt class="text-muted">Démarré le</dt>
                            <dd><?= date('d/m/Y', strtotime($project['started_at'])) ?></dd>
                        <?php endif; ?>
                        <?php if (!empty($project['delivered_at'])): ?>
                            <dt class="text-muted">Livré le</dt>
                            <dd class="text-success"><?= date('d/m/Y', strtotime($project['delivered_at'])) ?></dd>
                        <?php endif; ?>
                        <dt class="text-muted">Payé</dt>
                        <dd><?= $project['paid'] ? '<span class="text-success">Oui</span>' : '<span class="text-danger">Non</span>' ?></dd>
                    </dl>
                </div>
            </div>

            <!-- Notes admin -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-sticky"></i> Notes internes</h6>
                </div>
                <div class="card-body">
                    <form action="/admin/projects/<?= $project['id'] ?>/note" method="POST">
                        <textarea name="admin_notes" class="form-control form-control-sm mb-2" rows="4"><?= htmlspecialchars($project['admin_notes'] ?? '') ?></textarea>
                        <button type="submit" class="btn btn-sm btn-outline-secondary w-100">Sauvegarder</button>
                    </form>
                </div>
            </div>

            <!-- Historique -->
            <?php if (!empty($project['history'])): ?>
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="bi bi-clock-history"></i> Historique</h6>
                    </div>
                    <div class="list-group list-group-flush" style="max-height: 300px; overflow-y: auto;">
                        <?php foreach ($project['history'] as $h): ?>
                            <div class="list-group-item py-2">
                                <div class="d-flex justify-content-between">
                                    <span class="badge bg-<?= $sc[$h['new_status']] ?? 'secondary' ?>"><?= htmlspecialchars($statuses[$h['new_status']] ?? $h['new_status']) ?></span>
                                    <small class="text-muted"><?= date('d/m H:i', strtotime($h['created_at'])) ?></small>
                                </div>
                                <?php if (!empty($h['note'])): ?>
                                    <small class="text-muted"><?= htmlspecialchars($h['note']) ?></small>
                                <?php endif; ?>
                                <small class="d-block text-muted">par <?= htmlspecialchars($h['changed_by_name'] ?? '—') ?></small>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function updateTask(taskId, status) {
    fetch('/admin/projects/task/update', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'task_id=' + taskId + '&status=' + status
    });
}
document.addEventListener('DOMContentLoaded', function() {
    const c = document.getElementById('msgContainer');
    if (c) c.scrollTop = c.scrollHeight;
});
</script>
