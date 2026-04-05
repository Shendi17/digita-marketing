<!-- Landing Page Formation - Optimisée Conversion -->
<section class="landing-hero text-white" style="padding-top: 100px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 60vh;">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <?php if (!empty($formation['category_name'])): ?>
                    <span class="badge bg-white text-primary mb-3"><?= htmlspecialchars($formation['category_name']) ?></span>
                <?php endif; ?>
                <h1 class="display-4 fw-bold mb-3"><?= htmlspecialchars($formation['title']) ?></h1>
                <p class="lead mb-4"><?= htmlspecialchars($formation['description'] ?? '') ?></p>
                
                <div class="d-flex gap-4 mb-4 flex-wrap">
                    <div><i class="bi bi-clock"></i> <strong><?= $formation['duration_hours'] ?? '—' ?> heures</strong></div>
                    <div><i class="bi bi-bar-chart"></i> <strong><?= ucfirst($formation['level'] ?? 'Tous niveaux') ?></strong></div>
                    <div><i class="bi bi-people"></i> <strong><?= $formation['enrolled_count'] ?? 0 ?> inscrits</strong></div>
                    <?php if (($formation['rating'] ?? 0) > 0): ?>
                        <div><i class="bi bi-star-fill text-warning"></i> <strong><?= number_format($formation['rating'], 1) ?>/5</strong></div>
                    <?php endif; ?>
                </div>

                <div class="d-flex gap-3 flex-wrap">
                    <?php if ((float)($formation['price'] ?? 0) > 0): ?>
                        <a href="/formations/checkout/<?= $formation['id'] ?>" class="btn btn-warning btn-lg fw-bold px-4">
                            <i class="bi bi-cart-check"></i> S'inscrire — <?= number_format($formation['price'], 2) ?> €
                        </a>
                    <?php else: ?>
                        <form action="/formations/enroll/<?= $formation['id'] ?>" method="POST" class="d-inline">
                            <button type="submit" class="btn btn-warning btn-lg fw-bold px-4">
                                <i class="bi bi-play-circle"></i> Commencer gratuitement
                            </button>
                        </form>
                    <?php endif; ?>
                    <a href="#programme" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-list-check"></i> Voir le programme
                    </a>
                </div>
            </div>
            <div class="col-lg-5 text-center mt-4 mt-lg-0">
                <?php if (!empty($formation['image'])): ?>
                    <img src="<?= htmlspecialchars($formation['image']) ?>" alt="<?= htmlspecialchars($formation['title']) ?>" class="img-fluid rounded shadow-lg" style="max-height: 350px;">
                <?php else: ?>
                    <div class="bg-white bg-opacity-10 rounded p-5">
                        <i class="bi bi-mortarboard" style="font-size: 8rem; opacity: 0.5;"></i>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Garanties -->
<section class="py-4 bg-dark text-white">
    <div class="container">
        <div class="row text-center g-3">
            <div class="col-md-3 col-6">
                <i class="bi bi-shield-check fs-4 text-success"></i>
                <div class="small mt-1">Paiement sécurisé</div>
            </div>
            <div class="col-md-3 col-6">
                <i class="bi bi-infinity fs-4 text-info"></i>
                <div class="small mt-1">Accès illimité à vie</div>
            </div>
            <div class="col-md-3 col-6">
                <i class="bi bi-award fs-4 text-warning"></i>
                <div class="small mt-1">Certificat inclus</div>
            </div>
            <div class="col-md-3 col-6">
                <i class="bi bi-headset fs-4 text-primary"></i>
                <div class="small mt-1">Support dédié</div>
            </div>
        </div>
    </div>
</section>

<!-- Ce que vous allez apprendre -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Ce que vous allez apprendre</h2>
        <div class="row g-4">
            <?php
            $objectives = [];
            if (!empty($formation['objectives'])) {
                $objectives = json_decode($formation['objectives'], true);
            }
            if (empty($objectives)) {
                $title = str_replace('Formation ', '', $formation['title']);
                $objectives = [
                    "Maîtriser les fondamentaux de " . strtolower($title),
                    "Comprendre les meilleures pratiques et techniques avancées",
                    "Mettre en place des stratégies efficaces et mesurables",
                    "Éviter les erreurs courantes et optimiser vos résultats",
                    "Utiliser les outils professionnels recommandés",
                    "Appliquer vos connaissances sur des cas concrets"
                ];
            }
            ?>
            <?php foreach ($objectives as $obj): ?>
                <div class="col-md-6">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-check-circle-fill text-success fs-4 me-3 flex-shrink-0"></i>
                        <p class="mb-0"><?= htmlspecialchars($obj) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Programme -->
<section class="py-5" id="programme">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Programme de la formation</h2>
        <?php if (!empty($formation['modules'])): ?>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion" id="landingModules">
                        <?php foreach ($formation['modules'] as $i => $module): ?>
                            <div class="accordion-item shadow-sm mb-2">
                                <h2 class="accordion-header">
                                    <button class="accordion-button <?= $i > 0 ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#lm<?= $module['id'] ?>">
                                        <strong>Module <?= $i + 1 ?> : <?= htmlspecialchars($module['title']) ?></strong>
                                        <?php if (!empty($module['duration'])): ?>
                                            <span class="badge bg-secondary ms-2"><?= $module['duration'] ?> min</span>
                                        <?php endif; ?>
                                    </button>
                                </h2>
                                <div id="lm<?= $module['id'] ?>" class="accordion-collapse collapse <?= $i === 0 ? 'show' : '' ?>" data-bs-parent="#landingModules">
                                    <div class="accordion-body">
                                        <?php if (!empty($module['lessons'])): ?>
                                            <ul class="list-group list-group-flush">
                                                <?php foreach ($module['lessons'] as $lesson): ?>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span>
                                                            <?php if (!empty($lesson['is_free'])): ?>
                                                                <i class="bi bi-unlock text-success"></i>
                                                            <?php else: ?>
                                                                <i class="bi bi-lock text-muted"></i>
                                                            <?php endif; ?>
                                                            <?= htmlspecialchars($lesson['title']) ?>
                                                        </span>
                                                        <?php if (!empty($lesson['duration_minutes'])): ?>
                                                            <small class="text-muted"><?= $lesson['duration_minutes'] ?> min</small>
                                                        <?php endif; ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Avis -->
<?php if (!empty($reviews)): ?>
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold mb-2">Ce qu'en pensent nos apprenants</h2>
        <?php if (!empty($averageRating) && $averageRating['count'] > 0): ?>
            <p class="text-center text-muted mb-5">
                <span class="text-warning fs-5">
                    <?php for ($s = 1; $s <= 5; $s++): ?>
                        <i class="bi bi-star<?= $s <= round($averageRating['average']) ? '-fill' : '' ?>"></i>
                    <?php endfor; ?>
                </span>
                <?= number_format($averageRating['average'], 1) ?>/5 — <?= $averageRating['count'] ?> avis
            </p>
        <?php endif; ?>
        <div class="row g-4 justify-content-center">
            <?php foreach (array_slice($reviews, 0, 3) as $review): ?>
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="text-warning mb-2">
                                <?php for ($s = 1; $s <= 5; $s++): ?>
                                    <i class="bi bi-star<?= $s <= $review['rating'] ? '-fill' : '' ?>"></i>
                                <?php endfor; ?>
                            </div>
                            <?php if (!empty($review['title'])): ?>
                                <h6 class="fw-bold"><?= htmlspecialchars($review['title']) ?></h6>
                            <?php endif; ?>
                            <?php if (!empty($review['comment'])): ?>
                                <p class="text-muted small"><?= htmlspecialchars(mb_strimwidth($review['comment'], 0, 150, '...')) ?></p>
                            <?php endif; ?>
                            <p class="mb-0 small fw-bold"><?= htmlspecialchars($review['username']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- CTA Final -->
<section class="py-5 text-white text-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <h2 class="display-5 fw-bold mb-3">Prêt à vous lancer ?</h2>
        <p class="lead mb-4">Rejoignez <?= $formation['enrolled_count'] ?? 0 ?> apprenants et développez vos compétences dès aujourd'hui.</p>
        
        <?php if ((float)($formation['price'] ?? 0) > 0): ?>
            <div class="mb-3">
                <span class="display-4 fw-bold"><?= number_format($formation['price'], 2) ?> €</span>
            </div>
            <a href="/formations/checkout/<?= $formation['id'] ?>" class="btn btn-warning btn-lg fw-bold px-5 py-3">
                <i class="bi bi-cart-check"></i> S'inscrire maintenant
            </a>
        <?php else: ?>
            <form action="/formations/enroll/<?= $formation['id'] ?>" method="POST" class="d-inline">
                <button type="submit" class="btn btn-warning btn-lg fw-bold px-5 py-3">
                    <i class="bi bi-play-circle"></i> Commencer gratuitement
                </button>
            </form>
        <?php endif; ?>
        
        <p class="mt-3 small opacity-75">
            <i class="bi bi-shield-check"></i> Paiement sécurisé · Accès illimité · Certificat inclus
        </p>
    </div>
</section>
