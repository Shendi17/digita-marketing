<section class="py-5">
    <div class="container" style="max-width: 700px;">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/formations">Formations</a></li>
                <li class="breadcrumb-item"><a href="/formations/<?= htmlspecialchars($formation['slug'] ?? '') ?>"><?= htmlspecialchars(mb_strimwidth($formation['title'] ?? '', 0, 30, '...')) ?></a></li>
                <li class="breadcrumb-item active">Résultats Quiz</li>
            </ol>
        </nav>

        <?php if ($results): ?>
            <!-- Score principal -->
            <div class="card border-0 shadow-sm text-center mb-4">
                <div class="card-body py-5">
                    <?php if ($results['passed']): ?>
                        <div class="display-1 mb-3">🎉</div>
                        <h2 class="fw-bold text-success">Félicitations !</h2>
                        <p class="text-muted">Vous avez réussi le quiz</p>
                    <?php else: ?>
                        <div class="display-1 mb-3">📝</div>
                        <h2 class="fw-bold text-warning">Continuez vos efforts</h2>
                        <p class="text-muted">Le score requis est de <?= $quiz['passing_score'] ?>%</p>
                    <?php endif; ?>

                    <div class="display-4 fw-bold my-3 text-<?= $results['passed'] ? 'success' : 'warning' ?>">
                        <?= $results['percentage'] ?>%
                    </div>
                    <p class="mb-0">
                        <span class="badge bg-<?= $results['passed'] ? 'success' : 'warning' ?> fs-6">
                            <?= $results['score'] ?> / <?= $results['max_score'] ?> points
                        </span>
                    </p>
                </div>
            </div>

            <!-- Détail des réponses -->
            <?php if (!empty($results['results'])): ?>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="bi bi-list-check text-primary"></i> Détail des réponses</h5>
                    </div>
                    <div class="card-body p-0">
                        <?php foreach ($results['results'] as $i => $r): ?>
                            <div class="p-3 border-bottom d-flex align-items-start gap-3">
                                <span class="badge bg-<?= $r['is_correct'] ? 'success' : 'danger' ?> mt-1">
                                    <i class="bi bi-<?= $r['is_correct'] ? 'check' : 'x' ?>-lg"></i>
                                </span>
                                <div class="flex-grow-1">
                                    <strong>Question <?= $i + 1 ?></strong>
                                    <?php if (!empty($r['explanation'])): ?>
                                        <p class="text-muted small mb-0 mt-1">
                                            <i class="bi bi-lightbulb"></i> <?= htmlspecialchars($r['explanation']) ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Actions -->
            <div class="d-flex justify-content-center gap-3">
                <a href="/formations/<?= htmlspecialchars($formation['slug'] ?? '') ?>/learn" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i> Retour à la formation
                </a>
                <?php if (!$results['passed']): ?>
                    <a href="/formations/quiz/<?= $quiz['id'] ?>" class="btn btn-outline-warning">
                        <i class="bi bi-arrow-repeat"></i> Réessayer
                    </a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-clipboard-x display-1 text-muted"></i>
                <h4 class="mt-3">Aucun résultat disponible</h4>
                <a href="/formations/quiz/<?= $quiz['id'] ?>" class="btn btn-primary mt-3">
                    <i class="bi bi-pencil-square"></i> Passer le quiz
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>
