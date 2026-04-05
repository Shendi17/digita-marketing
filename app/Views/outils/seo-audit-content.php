<!-- Audit SEO Gratuit -->
<section class="py-5" style="padding-top: 120px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <h1 class="display-5 fw-bold"><i class="bi bi-search text-primary"></i> Audit SEO Gratuit</h1>
                    <p class="lead text-muted">Analysez le référencement de votre site web en 10 points clés</p>
                </div>

                <?php if (!empty($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?= htmlspecialchars($_SESSION['error_message']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['error_message']); ?>
                <?php endif; ?>

                <!-- Formulaire -->
                <div class="card shadow-sm mb-5">
                    <div class="card-body p-4">
                        <form action="/outils/audit-seo" method="POST">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                <input type="url" name="url" class="form-control" placeholder="https://votre-site.com" value="<?= htmlspecialchars($url ?? '') ?>" required>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search"></i> Analyser
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <?php if (!empty($result)): ?>
                    <?php if (!empty($result['error'])): ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($result['error']) ?>
                        </div>
                    <?php else: ?>
                        <!-- Score global -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-body text-center py-4">
                                <h3 class="mb-3">Score SEO</h3>
                                <?php
                                $score = $result['score'];
                                $scoreColor = $score >= 80 ? 'success' : ($score >= 50 ? 'warning' : 'danger');
                                ?>
                                <div class="position-relative d-inline-block mb-3">
                                    <div class="display-1 fw-bold text-<?= $scoreColor ?>"><?= $score ?></div>
                                    <small class="text-muted">/100</small>
                                </div>
                                <div class="progress mb-3" style="height: 12px;">
                                    <div class="progress-bar bg-<?= $scoreColor ?>" style="width: <?= $score ?>%"></div>
                                </div>
                                <p class="text-muted mb-0">
                                    <?= htmlspecialchars($result['url']) ?> &mdash; <?= $result['load_time'] ?>s
                                </p>
                            </div>
                        </div>

                        <!-- Détail des vérifications -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="bi bi-clipboard-check"></i> Détail de l'analyse</h5>
                            </div>
                            <div class="list-group list-group-flush">
                                <?php foreach ($result['checks'] as $check): ?>
                                    <?php
                                    $icon = $check['status'] === 'good' ? 'check-circle-fill text-success' : ($check['status'] === 'warning' ? 'exclamation-triangle-fill text-warning' : 'x-circle-fill text-danger');
                                    ?>
                                    <div class="list-group-item d-flex align-items-start">
                                        <i class="bi bi-<?= $icon ?> me-3 mt-1 fs-5"></i>
                                        <div>
                                            <strong><?= htmlspecialchars($check['name']) ?></strong>
                                            <div class="small text-muted"><?= htmlspecialchars($check['detail']) ?></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Recommandations -->
                        <?php if (!empty($result['recommendations'])): ?>
                            <div class="card shadow-sm mb-4 border-warning">
                                <div class="card-header bg-warning bg-opacity-10">
                                    <h5 class="mb-0"><i class="bi bi-lightbulb text-warning"></i> Recommandations</h5>
                                </div>
                                <div class="card-body">
                                    <ol class="mb-0">
                                        <?php foreach ($result['recommendations'] as $rec): ?>
                                            <li class="mb-2"><?= htmlspecialchars($rec) ?></li>
                                        <?php endforeach; ?>
                                    </ol>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Résumé technique -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-3 col-6">
                                <div class="card text-center">
                                    <div class="card-body py-2">
                                        <div class="fs-4 fw-bold"><?= $result['load_time'] ?>s</div>
                                        <small class="text-muted">Chargement</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="card text-center">
                                    <div class="card-body py-2">
                                        <div class="fs-4 fw-bold"><?= $result['images_count'] ?></div>
                                        <small class="text-muted">Images</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="card text-center">
                                    <div class="card-body py-2">
                                        <div class="fs-4 fw-bold"><?= $result['links_internal'] ?></div>
                                        <small class="text-muted">Liens internes</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="card text-center">
                                    <div class="card-body py-2">
                                        <div class="fs-4 fw-bold"><?= $result['links_external'] ?></div>
                                        <small class="text-muted">Liens externes</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CTA -->
                        <div class="card bg-primary bg-opacity-10 border-primary text-center">
                            <div class="card-body py-4">
                                <h5 class="fw-bold">Besoin d'aide pour améliorer votre SEO ?</h5>
                                <p class="text-muted mb-3">Nos experts peuvent optimiser votre site pour un meilleur référencement.</p>
                                <a href="/projets/brief" class="btn btn-primary"><i class="bi bi-rocket"></i> Demander un devis</a>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
