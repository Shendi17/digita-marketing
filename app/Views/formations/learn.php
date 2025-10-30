<?php require_once __DIR__ . '/../../../includes/partials/header.php'; ?>
<?php require_once __DIR__ . '/../../../includes/partials/navbar.php'; ?>

<style>
.lesson-sidebar {
    height: calc(100vh - 100px);
    overflow-y: auto;
    position: sticky;
    top: 20px;
}

.lesson-content {
    min-height: 500px;
}

.module-item {
    cursor: pointer;
    transition: all 0.3s;
}

.module-item:hover {
    background-color: #f8f9fa;
}

.lesson-item {
    cursor: pointer;
    padding: 10px 15px;
    border-left: 3px solid transparent;
    transition: all 0.3s;
}

.lesson-item:hover {
    background-color: #f8f9fa;
    border-left-color: #667eea;
}

.lesson-item.active {
    background-color: #e7f3ff;
    border-left-color: #667eea;
    font-weight: bold;
}

.lesson-item.completed {
    color: #28a745;
}

.lesson-item.completed i {
    color: #28a745;
}

.video-container {
    position: relative;
    padding-bottom: 56.25%;
    height: 0;
    overflow: hidden;
    background: #000;
    border-radius: 8px;
}

.video-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 400px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 8px;
    color: white;
}
</style>

<!-- Interface d'apprentissage -->
<div class="container-fluid px-0">
    <div class="row g-0">
        <!-- Sidebar - Liste des modules et leçons -->
        <div class="col-md-3 bg-light border-end">
            <div class="lesson-sidebar p-3">
                <!-- En-tête formation -->
                <div class="mb-4">
                    <h5 class="mb-2"><?= htmlspecialchars($formation['title']) ?></h5>
                    <div class="progress progress-thin">
                        <div class="progress-bar bg-success" style="width: <?= $progress ?>%"></div>
                    </div>
                    <small class="text-muted"><?= $progress ?>% complété</small>
                </div>

                <!-- Liste des modules -->
                <?php 
                // Trouver le module contenant la leçon active
                $activeModuleId = null;
                if (isset($currentLesson)) {
                    foreach ($formation['modules'] as $module) {
                        foreach ($module['lessons'] as $lesson) {
                            if ($lesson['id'] == $currentLesson['id']) {
                                $activeModuleId = $module['id'];
                                break 2;
                            }
                        }
                    }
                }
                ?>
                <div class="modules-list">
                    <?php foreach ($formation['modules'] as $moduleIndex => $module): ?>
                        <?php $isActiveModule = ($activeModuleId && $activeModuleId == $module['id']) || ($moduleIndex === 0 && !$activeModuleId); ?>
                        <div class="card border-0 mb-2 shadow-sm">
                            <div class="card-header bg-light">
                                <button class="btn btn-link text-decoration-none text-dark w-100 text-start p-0" 
                                        type="button" 
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#module<?= $module['id'] ?>"
                                        aria-expanded="<?= $isActiveModule ? 'true' : 'false' ?>">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-bold">Module <?= $moduleIndex + 1 ?></div>
                                            <small class="text-muted"><?= htmlspecialchars($module['title']) ?></small>
                                        </div>
                                        <i class="bi bi-chevron-down"></i>
                                    </div>
                                </button>
                            </div>
                            <div id="module<?= $module['id'] ?>" 
                                 class="collapse <?= $isActiveModule ? 'show' : '' ?>">
                                <div class="card-body p-0">
                                    <?php foreach ($module['lessons'] as $lessonIndex => $lesson): ?>
                                        <div class="lesson-item <?= isset($currentLesson) && $currentLesson['id'] == $lesson['id'] ? 'active' : '' ?>"
                                             onclick="window.location.href='/formations/<?= $formation['slug'] ?>/learn?lesson=<?= $lesson['id'] ?>'">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bi bi-play-circle"></i>
                                                    <span class="ms-2"><?= htmlspecialchars($lesson['title']) ?></span>
                                                </div>
                                                <small class="text-muted"><?= $lesson['duration_minutes'] ?> min</small>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Bouton retour -->
                <div class="mt-4">
                    <a href="/formations/<?= $formation['slug'] ?>" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-left"></i> Retour à la formation
                    </a>
                </div>
            </div>
        </div>

        <!-- Contenu principal - Leçon -->
        <div class="col-md-9">
            <div class="lesson-content p-4">
                <?php if (isset($currentLesson)): ?>
                    <!-- En-tête leçon -->
                    <div class="mb-4">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/formations">Formations</a></li>
                                <li class="breadcrumb-item"><a href="/formations/<?= $formation['slug'] ?>"><?= htmlspecialchars($formation['service_name']) ?></a></li>
                                <li class="breadcrumb-item active"><?= htmlspecialchars($currentLesson['title']) ?></li>
                            </ol>
                        </nav>
                        
                        <h2 class="mb-3"><?= htmlspecialchars($currentLesson['title']) ?></h2>
                        
                        <div class="d-flex gap-3 mb-3">
                            <span class="badge bg-primary">
                                <i class="bi bi-clock"></i> <?= $currentLesson['duration_minutes'] ?> minutes
                            </span>
                            <?php if ($currentLesson['is_free']): ?>
                                <span class="badge bg-success">
                                    <i class="bi bi-unlock"></i> Gratuit
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Vidéo (placeholder) -->
                    <div class="video-placeholder mb-4">
                        <div class="text-center">
                            <i class="bi bi-play-circle large-icon"></i>
                            <h4 class="mt-3">Vidéo de la leçon</h4>
                            <p class="mb-0">Durée : <?= $currentLesson['duration_minutes'] ?> minutes</p>
                        </div>
                    </div>

                    <!-- Contenu de la leçon -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h4 class="mb-3"><i class="bi bi-journal-text"></i> Contenu de la leçon</h4>
                            <div class="lesson-text">
                                <?php
                                // Générer du contenu de démonstration
                                $content = $currentLesson['content'] ?? "
                                <h5>Introduction</h5>
                                <p>Bienvenue dans cette leçon sur <strong>" . htmlspecialchars($currentLesson['title']) . "</strong>.</p>
                                
                                <h5>Objectifs d'apprentissage</h5>
                                <ul>
                                    <li>Comprendre les concepts fondamentaux</li>
                                    <li>Maîtriser les techniques avancées</li>
                                    <li>Appliquer les connaissances dans des cas pratiques</li>
                                </ul>
                                
                                <h5>Points clés</h5>
                                <p>Dans cette leçon, vous allez découvrir :</p>
                                <ul>
                                    <li><strong>Les bases</strong> : Comprendre les fondamentaux</li>
                                    <li><strong>Les outils</strong> : Découvrir les outils professionnels</li>
                                    <li><strong>Les stratégies</strong> : Mettre en place des stratégies efficaces</li>
                                    <li><strong>Les bonnes pratiques</strong> : Appliquer les meilleures méthodes</li>
                                </ul>
                                
                                <h5>Exercice pratique</h5>
                                <p>À la fin de cette leçon, vous devrez réaliser un exercice pratique pour valider vos acquis.</p>
                                ";
                                echo $content;
                                ?>
                            </div>
                        </div>
                    </div>

                    <!-- Ressources -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="mb-3"><i class="bi bi-download"></i> Ressources téléchargeables</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <a href="#" class="text-decoration-none">
                                        <i class="bi bi-file-pdf text-danger"></i> Support de cours (PDF)
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="#" class="text-decoration-none">
                                        <i class="bi bi-file-code text-primary"></i> Fichiers d'exercice
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="#" class="text-decoration-none">
                                        <i class="bi bi-link-45deg text-info"></i> Liens utiles
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <div class="d-flex justify-content-between align-items-center">
                        <?php if (isset($previousLesson)): ?>
                            <a href="/formations/<?= $formation['slug'] ?>/learn?lesson=<?= $previousLesson['id'] ?>" 
                               class="btn btn-outline-primary">
                                <i class="bi bi-arrow-left"></i> Leçon précédente
                            </a>
                        <?php else: ?>
                            <div></div>
                        <?php endif; ?>

                        <button class="btn btn-success" onclick="markAsCompleted(<?= $currentLesson['id'] ?>)">
                            <i class="bi bi-check-circle"></i> Marquer comme terminée
                        </button>

                        <?php if (isset($nextLesson)): ?>
                            <a href="/formations/<?= $formation['slug'] ?>/learn?lesson=<?= $nextLesson['id'] ?>" 
                               class="btn btn-primary">
                                Leçon suivante <i class="bi bi-arrow-right"></i>
                            </a>
                        <?php else: ?>
                            <a href="/formations/<?= $formation['slug'] ?>" class="btn btn-success">
                                <i class="bi bi-trophy"></i> Formation terminée !
                            </a>
                        <?php endif; ?>
                    </div>

                <?php else: ?>
                    <!-- Aucune leçon sélectionnée -->
                    <div class="text-center py-5">
                        <i class="bi bi-play-circle empty-icon"></i>
                        <h3 class="mt-4">Sélectionnez une leçon pour commencer</h3>
                        <p class="text-muted">Choisissez une leçon dans le menu de gauche</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function markAsCompleted(lessonId) {
    // Envoyer une requête AJAX pour marquer la leçon comme terminée
    fetch('/api/lessons/' + lessonId + '/complete', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Leçon marquée comme terminée !');
            location.reload();
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
    });
}
</script>

<?php require_once __DIR__ . '/../../../includes/partials/footer.php'; ?>
