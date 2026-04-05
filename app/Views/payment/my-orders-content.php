<!-- Mes Commandes -->
<section class="my-orders-page bg-light" style="padding-top: 120px !important; margin-top: 0 !important;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h1 class="h3 fw-bold mb-4"><i class="bi bi-receipt"></i> Mes commandes</h1>

                <?php if (!empty($orders)): ?>
                    <div class="card shadow-sm">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Articles</th>
                                        <th>Montant</th>
                                        <th>Statut</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td class="fw-bold"><?= $order['id'] ?></td>
                                            <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                                            <td>
                                                <span class="text-truncate d-inline-block" style="max-width: 250px;">
                                                    <?= htmlspecialchars($order['items_summary'] ?? 'Formation') ?>
                                                </span>
                                                <?php if (($order['item_count'] ?? 0) > 1): ?>
                                                    <span class="badge bg-secondary"><?= $order['item_count'] ?> articles</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="fw-bold"><?= number_format($order['amount'], 2) ?> €</td>
                                            <td>
                                                <?php
                                                $statusClasses = [
                                                    'pending' => 'bg-warning text-dark',
                                                    'paid' => 'bg-success',
                                                    'cancelled' => 'bg-secondary',
                                                    'refunded' => 'bg-info'
                                                ];
                                                $statusLabels = [
                                                    'pending' => 'En attente',
                                                    'paid' => 'Payée',
                                                    'cancelled' => 'Annulée',
                                                    'refunded' => 'Remboursée'
                                                ];
                                                $cls = $statusClasses[$order['status']] ?? 'bg-secondary';
                                                $lbl = $statusLabels[$order['status']] ?? $order['status'];
                                                ?>
                                                <span class="badge <?= $cls ?>"><?= $lbl ?></span>
                                            </td>
                                            <td class="text-end">
                                                <a href="/mes-commandes/<?= $order['id'] ?>" class="btn btn-sm btn-outline-primary" title="Détail">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="card shadow-sm">
                        <div class="card-body text-center py-5">
                            <i class="bi bi-cart-x text-muted" style="font-size: 3rem;"></i>
                            <h5 class="mt-3 text-muted">Aucune commande</h5>
                            <p class="text-muted">Vous n'avez pas encore effectué d'achat.</p>
                            <a href="/formations" class="btn btn-primary">
                                <i class="bi bi-mortarboard"></i> Découvrir nos formations
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="mt-3">
                    <a href="/mes-formations" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Mes formations
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
