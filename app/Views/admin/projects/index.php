<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold"><i class="bi bi-kanban"></i> Projets Clients</h1>
            <p class="text-muted mb-0"><?= $stats['total'] ?> projets · <?= $stats['active'] ?> actifs · <?= $unreadMessages ?> messages non lus</p>
        </div>
        <div class="btn-group">
            <a href="/admin/projects?view=kanban" class="btn btn-<?= $currentView === 'kanban' ? 'primary' : 'outline-primary' ?>">
                <i class="bi bi-kanban"></i> Kanban
            </a>
            <a href="/admin/projects?view=list" class="btn btn-<?= $currentView === 'list' ? 'primary' : 'outline-primary' ?>">
                <i class="bi bi-list-ul"></i> Liste
            </a>
        </div>
    </div>

    <!-- Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-2 col-4">
            <div class="card text-center shadow-sm">
                <div class="card-body py-2">
                    <div class="fs-4 fw-bold text-warning"><?= $stats['pending'] ?></div>
                    <small class="text-muted">En attente</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-4">
            <div class="card text-center shadow-sm">
                <div class="card-body py-2">
                    <div class="fs-4 fw-bold text-info"><?= $stats['active'] ?></div>
                    <small class="text-muted">Actifs</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-4">
            <div class="card text-center shadow-sm">
                <div class="card-body py-2">
                    <div class="fs-4 fw-bold text-success"><?= $stats['completed'] ?></div>
                    <small class="text-muted">Terminés</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card text-center shadow-sm">
                <div class="card-body py-2">
                    <div class="fs-4 fw-bold text-primary"><?= number_format($stats['total_revenue'], 0) ?> €</div>
                    <small class="text-muted">CA total</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card text-center shadow-sm">
                <div class="card-body py-2">
                    <div class="fs-4 fw-bold"><?= $stats['avg_delivery_days'] ?>j</div>
                    <small class="text-muted">Délai moyen</small>
                </div>
            </div>
        </div>
    </div>

    <?php if ($currentView === 'kanban'): ?>
    <!-- Vue Kanban -->
    <div class="row g-3" style="overflow-x: auto; flex-wrap: nowrap;">
        <?php
        $kanbanLabels = [
            'pending' => ['En attente', 'warning'],
            'generating' => ['Génération IA', 'info'],
            'review' => ['En révision', 'primary'],
            'revision' => ['Corrections', 'secondary'],
            'approved' => ['Approuvé', 'success'],
            'delivered' => ['Livré', 'dark']
        ];
        foreach ($kanbanLabels as $status => $info):
            $label = $info[0];
            $badgeColor = $info[1];
            $items = $kanban[$status] ?? [];
        ?>
            <div class="col" style="min-width: 280px;">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-<?= $badgeColor ?> text-white d-flex justify-content-between">
                        <strong><?= $label ?></strong>
                        <span class="badge bg-white text-dark"><?= count($items) ?></span>
                    </div>
                    <div class="card-body p-2" style="min-height: 200px;">
                        <?php if (empty($items)): ?>
                            <p class="text-muted text-center small py-3">Aucun projet</p>
                        <?php else: ?>
                            <?php foreach ($items as $p): ?>
                                <a href="/admin/projects/<?= $p['id'] ?>" class="card mb-2 text-decoration-none border-start border-3 border-<?= $badgeColor ?>">
                                    <div class="card-body p-2">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <strong class="small text-dark"><?= htmlspecialchars(mb_strimwidth($p['title'], 0, 35, '...')) ?></strong>
                                            <?php if ($p['priority'] === 'urgent'): ?>
                                                <span class="badge bg-danger">!</span>
                                            <?php elseif ($p['priority'] === 'high'): ?>
                                                <span class="badge bg-warning text-dark">↑</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-1">
                                            <small class="text-muted"><?= htmlspecialchars($p['client_name'] ?? $p['client_email']) ?></small>
                                            <?php if (($p['unread_client_messages'] ?? 0) > 0): ?>
                                                <span class="badge bg-danger rounded-pill"><?= $p['unread_client_messages'] ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <?php if ($p['price'] > 0): ?>
                                            <small class="text-primary fw-bold"><?= number_format($p['price'], 0) ?> €</small>
                                        <?php endif; ?>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php else: ?>
    <!-- Vue Liste -->
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Projet</th>
                        <th>Client</th>
                        <th>Type</th>
                        <th>Statut</th>
                        <th>Prix</th>
                        <th>Priorité</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projects as $p): ?>
                        <tr>
                            <td><?= $p['id'] ?></td>
                            <td>
                                <strong><?= htmlspecialchars(mb_strimwidth($p['title'], 0, 40, '...')) ?></strong>
                                <?php if (($p['unread_client_messages'] ?? 0) > 0): ?>
                                    <span class="badge bg-danger rounded-pill ms-1"><?= $p['unread_client_messages'] ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="small"><?= htmlspecialchars($p['client_name'] ?? $p['client_email']) ?></td>
                            <td><span class="badge bg-secondary"><?= htmlspecialchars($types[$p['project_type']] ?? $p['project_type']) ?></span></td>
                            <td>
                                <?php
                                $sc = ['draft'=>'light','pending'=>'warning','generating'=>'info','review'=>'primary','revision'=>'secondary','approved'=>'success','delivered'=>'success','completed'=>'dark','cancelled'=>'danger'];
                                ?>
                                <span class="badge bg-<?= $sc[$p['status']] ?? 'secondary' ?>"><?= htmlspecialchars($statuses[$p['status']] ?? $p['status']) ?></span>
                            </td>
                            <td><?= $p['price'] > 0 ? number_format($p['price'], 0) . ' €' : '—' ?></td>
                            <td>
                                <?php if ($p['priority'] === 'urgent'): ?>
                                    <span class="badge bg-danger">Urgent</span>
                                <?php elseif ($p['priority'] === 'high'): ?>
                                    <span class="badge bg-warning text-dark">Haute</span>
                                <?php else: ?>
                                    <span class="text-muted small"><?= ucfirst($p['priority']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="small text-muted"><?= date('d/m/Y', strtotime($p['created_at'])) ?></td>
                            <td>
                                <a href="/admin/projects/<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
</div>
