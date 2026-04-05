<!-- Sidebar modules/leçons -->
<div class="learn-sidebar" id="learnSidebar">
    <div class="p-3 border-bottom">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <small class="text-muted fw-semibold">PROGRESSION</small>
            <span class="badge bg-<?= ($progress['percentage'] ?? 0) >= 100 ? 'success' : 'primary' ?>">
                <?= $progress['percentage'] ?? 0 ?>%
            </span>
        </div>
        <div class="progress" style="height: 6px;">
            <div class="progress-bar bg-success" style="width: <?= $progress['percentage'] ?? 0 ?>%"></div>
        </div>
        <small class="text-muted d-block mt-1">
            <?= $progress['completed_lessons'] ?? 0 ?> / <?= $progress['total_lessons'] ?? 0 ?> leçons
        </small>
    </div>

    <?php foreach ($formation['modules'] as $mIndex => $module): ?>
        <div class="module-header" data-bs-toggle="collapse" data-bs-target="#module<?= $module['id'] ?>">
            <div class="d-flex justify-content-between align-items-center">
                <span><i class="bi bi-folder2 me-1"></i> Module <?= $mIndex + 1 ?></span>
                <i class="bi bi-chevron-down small"></i>
            </div>
            <div class="small fw-normal mt-1"><?= htmlspecialchars($module['title']) ?></div>
        </div>
        <div class="collapse <?= $currentLesson && in_array($currentLesson['id'], array_column($module['lessons'], 'id')) ? 'show' : '' ?>" 
             id="module<?= $module['id'] ?>">
            <?php foreach ($module['lessons'] as $lesson): ?>
                <?php 
                    $isCompleted = is_array($completedLessons) && in_array($lesson['id'], $completedLessons);
                    $isActive = $currentLesson && $currentLesson['id'] == $lesson['id'];
                ?>
                <a href="/formations/<?= htmlspecialchars($formation['slug']) ?>/learn?lesson=<?= $lesson['id'] ?>" 
                   class="lesson-item <?= $isActive ? 'active' : '' ?> <?= $isCompleted ? 'completed' : '' ?>">
                    <span class="lesson-check">
                        <?php if ($isCompleted): ?>
                            <i class="bi bi-check-circle-fill text-success"></i>
                        <?php elseif ($isActive): ?>
                            <i class="bi bi-play-circle-fill text-primary"></i>
                        <?php else: ?>
                            <i class="bi bi-circle text-muted"></i>
                        <?php endif; ?>
                    </span>
                    <span class="text-truncate"><?= htmlspecialchars($lesson['title']) ?></span>
                </a>
            <?php endforeach; ?>

            <?php if ($moduleQuiz && isset($module['id']) && $moduleQuiz['module_id'] == $module['id']): ?>
                <a href="/formations/quiz/<?= $moduleQuiz['id'] ?>" 
                   class="lesson-item <?= ($moduleQuiz['user_passed'] ?? false) ? 'completed' : '' ?>">
                    <span class="lesson-check">
                        <?php if ($moduleQuiz['user_passed'] ?? false): ?>
                            <i class="bi bi-patch-check-fill text-success"></i>
                        <?php else: ?>
                            <i class="bi bi-question-circle text-warning"></i>
                        <?php endif; ?>
                    </span>
                    <span class="text-truncate"><strong>Quiz</strong> — <?= htmlspecialchars($moduleQuiz['title']) ?></span>
                </a>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    <?php if ($isComplete): ?>
        <div class="p-3 border-top bg-success bg-opacity-10">
            <div class="text-center">
                <i class="bi bi-trophy-fill text-success display-6"></i>
                <p class="fw-semibold text-success mb-2">Formation terminée !</p>
                <a href="/formations/<?= $formation['id'] ?>/certificate" class="btn btn-success btn-sm w-100">
                    <i class="bi bi-award"></i> Obtenir mon certificat
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Contenu principal -->
<div class="learn-content">
    <?php if ($currentLesson): ?>
        <!-- Vidéo si disponible -->
        <?php if (!empty($currentLesson['video_url'])): ?>
            <div class="video-container">
                <?php 
                $videoUrl = $currentLesson['video_url'];
                if (strpos($videoUrl, 'youtube.com') !== false || strpos($videoUrl, 'youtu.be') !== false) {
                    preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $videoUrl, $matches);
                    $ytId = $matches[1] ?? '';
                    echo '<iframe src="https://www.youtube.com/embed/' . htmlspecialchars($ytId) . '?rel=0" frameborder="0" allowfullscreen></iframe>';
                } elseif (strpos($videoUrl, 'vimeo.com') !== false) {
                    preg_match('/vimeo\.com\/(\d+)/', $videoUrl, $matches);
                    $vimeoId = $matches[1] ?? '';
                    echo '<iframe src="https://player.vimeo.com/video/' . htmlspecialchars($vimeoId) . '" frameborder="0" allowfullscreen></iframe>';
                } else {
                    echo '<video src="' . htmlspecialchars($videoUrl) . '" controls></video>';
                }
                ?>
            </div>
        <?php endif; ?>

        <!-- Contenu de la leçon -->
        <div class="lesson-content-area">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <small class="text-muted"><?= htmlspecialchars($currentLesson['module_title'] ?? '') ?></small>
                    <h2 class="fw-bold mb-0"><?= htmlspecialchars($currentLesson['title']) ?></h2>
                    <?php if (!empty($currentLesson['duration_minutes'])): ?>
                        <small class="text-muted"><i class="bi bi-clock"></i> <?= $currentLesson['duration_minutes'] ?> min</small>
                    <?php endif; ?>
                </div>
                <?php 
                    $lessonCompleted = is_array($completedLessons) && in_array($currentLesson['id'], $completedLessons);
                ?>
                <button class="btn btn-<?= $lessonCompleted ? 'success' : 'outline-success' ?> btn-sm" 
                        id="completeBtn" <?= $lessonCompleted ? 'disabled' : '' ?>
                        onclick="markComplete(<?= $currentLesson['id'] ?>, <?= $formation['id'] ?>)">
                    <i class="bi bi-<?= $lessonCompleted ? 'check-circle-fill' : 'check-circle' ?>"></i>
                    <?= $lessonCompleted ? 'Terminée' : 'Marquer comme terminée' ?>
                </button>
            </div>

            <!-- Contenu HTML de la leçon -->
            <?php if (!empty($currentLesson['content'])): ?>
                <div class="lesson-body mb-4">
                    <?= $currentLesson['content'] ?>
                </div>
            <?php else: ?>
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-journal-text display-3"></i>
                    <p class="mt-3">Le contenu de cette leçon sera bientôt disponible.</p>
                </div>
            <?php endif; ?>

            <!-- Ressources -->
            <?php if (!empty($currentLesson['resources'])): ?>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h6 class="mb-0"><i class="bi bi-paperclip text-primary"></i> Ressources</h6>
                    </div>
                    <div class="card-body">
                        <?= $currentLesson['resources'] ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Navigation leçons -->
            <div class="d-flex justify-content-between align-items-center border-top pt-4 mt-4">
                <?php if ($previousLesson): ?>
                    <a href="/formations/<?= htmlspecialchars($formation['slug']) ?>/learn?lesson=<?= $previousLesson['id'] ?>" 
                       class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Précédente
                    </a>
                <?php else: ?>
                    <div></div>
                <?php endif; ?>

                <?php if ($nextLesson): ?>
                    <a href="/formations/<?= htmlspecialchars($formation['slug']) ?>/learn?lesson=<?= $nextLesson['id'] ?>" 
                       class="btn btn-primary">
                        Suivante <i class="bi bi-arrow-right"></i>
                    </a>
                <?php elseif ($isComplete): ?>
                    <a href="/formations/<?= $formation['id'] ?>/certificate" class="btn btn-success">
                        <i class="bi bi-award"></i> Obtenir mon certificat
                    </a>
                <?php else: ?>
                    <button class="btn btn-secondary" disabled>
                        Dernière leçon
                    </button>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="lesson-content-area text-center py-5">
            <i class="bi bi-journal-x display-1 text-muted"></i>
            <h4 class="mt-3">Aucune leçon disponible</h4>
            <p class="text-muted">Cette formation ne contient pas encore de leçons.</p>
            <a href="/formations/<?= htmlspecialchars($formation['slug']) ?>" class="btn btn-primary">
                Retour à la formation
            </a>
        </div>
    <?php endif; ?>
</div>

<script>
function markComplete(lessonId, formationId) {
    var btn = document.getElementById('completeBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="bi bi-hourglass-split"></i> En cours...';
    
    var formData = new FormData();
    formData.append('lesson_id', lessonId);
    formData.append('formation_id', formationId);
    
    fetch('/formations/complete-lesson', {
        method: 'POST',
        body: formData
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (data.success) {
            btn.className = 'btn btn-success btn-sm';
            btn.innerHTML = '<i class="bi bi-check-circle-fill"></i> Terminée';
            
            // Mettre à jour la progression dans la sidebar
            if (data.progress) {
                var pct = data.progress.percentage;
                document.querySelectorAll('.progress-bar').forEach(function(bar) {
                    bar.style.width = pct + '%';
                });
                // Recharger pour mettre à jour les icônes
                setTimeout(function() { location.reload(); }, 500);
            }
        } else {
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-check-circle"></i> Marquer comme terminée';
        }
    })
    .catch(function() {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-check-circle"></i> Marquer comme terminée';
    });
}
</script>
