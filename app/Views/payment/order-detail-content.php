<!-- Détail Commande -->
<section class="order-detail-page bg-light" style="padding-top: 120px !important; margin-top: 0 !important;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb bg-white p-3 rounded shadow-sm">
                        <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Accueil</a></li>
                        <li class="breadcrumb-item"><a href="/mes-commandes" class="text-decoration-none">Mes commandes</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Commande #<?= $order['id'] ?></li>
                    </ol>
                </nav>

                <h1 class="h3 fw-bold mb-4"><i class="bi bi-receipt-cutoff"></i> Commande #<?= $order['id'] ?></h1>

                <!-- Statut -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <p class="mb-1 text-muted small">Date de commande</p>
                                <p class="fw-bold mb-0"><?= date('d/m/Y à H:i', strtotime($order['created_at'])) ?></p>
                            </div>
                            <div class="col-md-3">
                                <p class="mb-1 text-muted small">Statut</p>
                                <?php
                                $statusClasses = ['pending' => 'bg-warning text-dark', 'paid' => 'bg-success', 'cancelled' => 'bg-secondary', 'refunded' => 'bg-info'];
                                $statusLabels = ['pending' => 'En attente', 'paid' => 'Payée', 'cancelled' => 'Annulée', 'refunded' => 'Remboursée'];
                                ?>
                                <span class="badge <?= $statusClasses[$order['status']] ?? 'bg-secondary' ?> fs-6">
                                    <?= $statusLabels[$order['status']] ?? $order['status'] ?>
                                </span>
                            </div>
                            <div class="col-md-3 text-end">
                                <p class="mb-1 text-muted small">Montant</p>
                                <p class="fw-bold fs-4 text-primary mb-0"><?= number_format($order['amount'], 2) ?> €</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Articles -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="bi bi-bag"></i> Articles</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Article</th>
                                    <th>Type</th>
                                    <th class="text-end">Prix</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($order['items'])): ?>
                                    <?php foreach ($order['items'] as $item): ?>
                                        <tr>
                                            <td>
                                                <?= htmlspecialchars($item['product_name'] ?? 'Article') ?>
                                                <?php if ($item['product_type'] === 'formation' && !empty($item['product_id'])): ?>
                                                    <br><small class="text-muted">Formation #<?= $item['product_id'] ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td><span class="badge bg-primary"><?= ucfirst($item['product_type'] ?? 'formation') ?></span></td>
                                            <td class="text-end fw-bold"><?= number_format($item['price'], 2) ?> €</td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                            <tfoot class="table-light">
                                <?php if (!empty($order['discount_amount']) && $order['discount_amount'] > 0): ?>
                                    <tr>
                                        <td colspan="2" class="text-end text-success">Réduction</td>
                                        <td class="text-end text-success">-<?= number_format($order['discount_amount'], 2) ?> €</td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td colspan="2" class="text-end fw-bold">Total</td>
                                    <td class="text-end fw-bold fs-5 text-primary"><?= number_format($order['amount'], 2) ?> €</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Facture -->
                <?php if ($invoice): ?>
                    <div class="card shadow-sm mb-4">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1"><i class="bi bi-file-earmark-text"></i> Facture <?= htmlspecialchars($invoice['invoice_number']) ?></h6>
                                <small class="text-muted">Émise le <?= date('d/m/Y', strtotime($invoice['created_at'])) ?></small>
                            </div>
                            <a href="/facture/<?= $invoice['id'] ?>" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-download"></i> Voir la facture
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Numéro de facture -->
                <?php if (!empty($order['invoice_number'])): ?>
                    <div class="text-muted small mb-3">
                        <i class="bi bi-hash"></i> Réf. facture : <?= htmlspecialchars($order['invoice_number']) ?>
                    </div>
                <?php endif; ?>

                <a href="/mes-commandes" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Retour aux commandes
                </a>
            </div>
        </div>
    </div>
</section>
