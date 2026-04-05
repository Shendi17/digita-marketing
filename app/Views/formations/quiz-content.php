<section class="py-5">
    <div class="container" style="max-width: 800px;">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/formations">Formations</a></li>
                <li class="breadcrumb-item"><a href="/formations/<?= htmlspecialchars($formation['slug'] ?? '') ?>"><?= htmlspecialchars(mb_strimwidth($formation['title'] ?? '', 0, 30, '...')) ?></a></li>
                <li class="breadcrumb-item active">Quiz</li>
            </ol>
        </nav>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white py-3">
                <h4 class="mb-1"><i class="bi bi-question-circle-fill"></i> <?= htmlspecialchars($quiz['title']) ?></h4>
                <?php if (!empty($quiz['description'])): ?>
                    <p class="mb-0 opacity-75 small"><?= htmlspecialchars($quiz['description']) ?></p>
                <?php endif; ?>
                <div class="d-flex gap-3 mt-2 small">
                    <span><i class="bi bi-list-check"></i> <?= count($questions) ?> questions</span>
                    <span><i class="bi bi-bullseye"></i> Score requis : <?= $quiz['passing_score'] ?>%</span>
                    <?php if ($quiz['time_limit_minutes'] > 0): ?>
                        <span><i class="bi bi-clock"></i> <?= $quiz['time_limit_minutes'] ?> min</span>
                    <?php endif; ?>
                    <?php if ($quiz['max_attempts'] > 0): ?>
                        <span><i class="bi bi-arrow-repeat"></i> <?= $attemptCount ?>/<?= $quiz['max_attempts'] ?> tentatives</span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card-body p-4">
                <!-- Meilleur résultat précédent -->
                <?php if ($bestAttempt): ?>
                    <div class="alert alert-<?= $bestAttempt['passed'] ? 'success' : 'warning' ?> d-flex align-items-center mb-4">
                        <i class="bi bi-<?= $bestAttempt['passed'] ? 'trophy-fill' : 'exclamation-triangle-fill' ?> me-2 fs-5"></i>
                        <div>
                            <strong>Meilleur résultat :</strong> <?= $bestAttempt['percentage'] ?>% 
                            (<?= $bestAttempt['score'] ?>/<?= $bestAttempt['max_score'] ?> points)
                            — <?= $bestAttempt['passed'] ? 'Réussi' : 'Non réussi' ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($canAttempt && !empty($questions)): ?>
                    <form method="POST" action="/formations/quiz/<?= $quiz['id'] ?>/submit" id="quizForm">
                        <?php foreach ($questions as $qIndex => $question): ?>
                            <div class="mb-4 p-3 bg-light rounded">
                                <h6 class="fw-bold mb-3">
                                    <span class="badge bg-primary me-2"><?= $qIndex + 1 ?></span>
                                    <?= htmlspecialchars($question['question']) ?>
                                    <small class="text-muted fw-normal ms-2">(<?= $question['points'] ?> pt<?= $question['points'] > 1 ? 's' : '' ?>)</small>
                                </h6>

                                <?php if ($question['question_type'] === 'single' || $question['question_type'] === 'true_false'): ?>
                                    <?php foreach ($question['answers'] as $answer): ?>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" 
                                                   name="question_<?= $question['id'] ?>" 
                                                   value="<?= $answer['id'] ?>" 
                                                   id="answer_<?= $answer['id'] ?>" required>
                                            <label class="form-check-label" for="answer_<?= $answer['id'] ?>">
                                                <?= htmlspecialchars($answer['answer_text']) ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                <?php elseif ($question['question_type'] === 'multiple'): ?>
                                    <small class="text-muted d-block mb-2"><i class="bi bi-info-circle"></i> Plusieurs réponses possibles</small>
                                    <?php foreach ($question['answers'] as $answer): ?>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="question_<?= $question['id'] ?>[]" 
                                                   value="<?= $answer['id'] ?>" 
                                                   id="answer_<?= $answer['id'] ?>">
                                            <label class="form-check-label" for="answer_<?= $answer['id'] ?>">
                                                <?= htmlspecialchars($answer['answer_text']) ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="bi bi-send-fill"></i> Soumettre mes réponses
                            </button>
                        </div>
                    </form>
                <?php elseif (empty($questions)): ?>
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-journal-x display-3"></i>
                        <p class="mt-3">Ce quiz ne contient pas encore de questions.</p>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="bi bi-lock-fill display-3 text-muted"></i>
                        <p class="mt-3 text-muted">Vous avez atteint le nombre maximum de tentatives.</p>
                        <a href="/formations/quiz/<?= $quiz['id'] ?>/results" class="btn btn-outline-primary">
                            <i class="bi bi-bar-chart"></i> Voir mes résultats
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
