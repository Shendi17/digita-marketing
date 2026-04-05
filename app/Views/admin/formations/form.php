<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">
                <i class="bi bi-<?= $formation ? 'pencil-square' : 'plus-circle-fill' ?> text-primary"></i>
                <?= $formation ? 'Modifier la formation' : 'Nouvelle formation' ?>
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="/admin/formations">Formations</a></li>
                    <li class="breadcrumb-item active"><?= $formation ? 'Modifier' : 'Créer' ?></li>
                </ol>
            </nav>
        </div>
        <a href="/admin/formations" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour à la liste
        </a>
    </div>

    <!-- Messages flash -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle-fill"></i> <?= htmlspecialchars($_SESSION['success_message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle-fill"></i> <?= htmlspecialchars($_SESSION['error_message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <form method="POST" action="<?= $formation ? '/admin/formations/update/' . $formation['id'] : '/admin/formations/store' ?>" 
          enctype="multipart/form-data">
        <div class="row">
            <!-- Colonne principale -->
            <div class="col-lg-8">
                <!-- Titre -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <label for="title" class="form-label fw-semibold">Titre de la formation <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control form-control-lg" 
                               placeholder="Ex: Maîtriser le SEO en 2026..."
                               value="<?= htmlspecialchars($formation['title'] ?? '') ?>" required>
                        <?php if ($formation): ?>
                            <small class="text-muted mt-1 d-block">
                                <i class="bi bi-link-45deg"></i> Slug : <code><?= htmlspecialchars($formation['slug']) ?></code>
                            </small>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Description (TinyMCE) -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <label for="description" class="form-label fw-semibold">Description de la formation</label>
                        <textarea name="description" id="description"><?= htmlspecialchars($formation['description'] ?? '') ?></textarea>
                    </div>
                </div>

                <!-- Modules & Leçons (lecture seule si existants) -->
                <?php if ($formation && !empty($formation['modules'])): ?>
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-0">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-list-nested text-info"></i> Modules & Leçons
                                <span class="badge bg-info ms-2"><?= count($formation['modules']) ?> modules</span>
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="accordion" id="modulesAccordion">
                                <?php foreach ($formation['modules'] as $index => $module): ?>
                                    <div class="accordion-item border-0 border-bottom">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button <?= $index > 0 ? 'collapsed' : '' ?>" type="button" 
                                                    data-bs-toggle="collapse" data-bs-target="#module<?= $module['id'] ?>">
                                                <span class="badge bg-primary me-2"><?= $index + 1 ?></span>
                                                <?= htmlspecialchars($module['title']) ?>
                                                <span class="badge bg-light text-dark ms-auto me-2">
                                                    <?= count($module['lessons']) ?> leçon(s)
                                                </span>
                                            </button>
                                        </h2>
                                        <div id="module<?= $module['id'] ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>"
                                             data-bs-parent="#modulesAccordion">
                                            <div class="accordion-body p-0">
                                                <?php if (!empty($module['lessons'])): ?>
                                                    <ul class="list-group list-group-flush">
                                                        <?php foreach ($module['lessons'] as $lessonIndex => $lesson): ?>
                                                            <li class="list-group-item ps-5">
                                                                <i class="bi bi-play-circle text-primary me-2"></i>
                                                                <span class="text-muted me-2"><?= $lessonIndex + 1 ?>.</span>
                                                                <?= htmlspecialchars($lesson['title']) ?>
                                                                <?php if (!empty($lesson['duration'])): ?>
                                                                    <small class="text-muted ms-2">
                                                                        <i class="bi bi-clock"></i> <?= htmlspecialchars($lesson['duration']) ?>
                                                                    </small>
                                                                <?php endif; ?>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                <?php else: ?>
                                                    <div class="p-3 text-muted small">Aucune leçon dans ce module</div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- SEO -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-search text-success"></i> Optimisation SEO
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="meta_title" class="form-label fw-semibold">Meta Title</label>
                            <input type="text" name="meta_title" id="meta_title" class="form-control" 
                                   placeholder="Titre pour les moteurs de recherche"
                                   value="<?= htmlspecialchars($formation['meta_title'] ?? '') ?>" maxlength="70">
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">Laissez vide pour utiliser le titre</small>
                                <small class="seo-counter" id="metaTitleCount">0/60</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="meta_description" class="form-label fw-semibold">Meta Description</label>
                            <textarea name="meta_description" id="meta_description" class="form-control" rows="3" 
                                      placeholder="Description pour les moteurs de recherche"
                                      maxlength="170"><?= htmlspecialchars($formation['meta_description'] ?? '') ?></textarea>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">Recommandé : 120-160 caractères</small>
                                <small class="seo-counter" id="metaDescCount">0/160</small>
                            </div>
                        </div>
                        <div class="mb-0">
                            <label for="meta_keywords" class="form-label fw-semibold">Mots-clés</label>
                            <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" 
                                   placeholder="mot-clé 1, mot-clé 2..."
                                   value="<?= htmlspecialchars($formation['meta_keywords'] ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Publication -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-send-fill text-primary"></i> Publication
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="status" class="form-label fw-semibold">Statut</label>
                            <select name="status" id="status" class="form-select">
                                <option value="draft" <?= ($formation['status'] ?? 'draft') === 'draft' ? 'selected' : '' ?>>Brouillon</option>
                                <option value="published" <?= ($formation['status'] ?? '') === 'published' ? 'selected' : '' ?>>Publiée</option>
                            </select>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg"></i> <?= $formation ? 'Mettre à jour' : 'Créer la formation' ?>
                            </button>
                            <?php if ($formation && $formation['status'] === 'published'): ?>
                                <a href="/formations/<?= htmlspecialchars($formation['slug']) ?>" class="btn btn-outline-info" target="_blank">
                                    <i class="bi bi-eye"></i> Voir la formation
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Catégorie -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-folder-fill text-warning"></i> Catégorie
                        </h5>
                    </div>
                    <div class="card-body">
                        <select name="category_id" class="form-select">
                            <option value="">— Aucune catégorie —</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= ($formation['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Détails formation -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-gear-fill text-secondary"></i> Détails
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="level" class="form-label fw-semibold">Niveau</label>
                            <select name="level" id="level" class="form-select">
                                <option value="debutant" <?= ($formation['level'] ?? 'debutant') === 'debutant' ? 'selected' : '' ?>>Débutant</option>
                                <option value="intermediaire" <?= ($formation['level'] ?? '') === 'intermediaire' ? 'selected' : '' ?>>Intermédiaire</option>
                                <option value="avance" <?= ($formation['level'] ?? '') === 'avance' ? 'selected' : '' ?>>Avancé</option>
                                <option value="expert" <?= ($formation['level'] ?? '') === 'expert' ? 'selected' : '' ?>>Expert</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="duration" class="form-label fw-semibold">Durée</label>
                            <input type="text" name="duration" id="duration" class="form-control" 
                                   placeholder="Ex: 12h, 3 semaines..."
                                   value="<?= htmlspecialchars($formation['duration'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label fw-semibold">Prix (€)</label>
                            <input type="number" name="price" id="price" class="form-control" 
                                   step="0.01" min="0" placeholder="0 = Gratuit"
                                   value="<?= htmlspecialchars($formation['price'] ?? '0') ?>">
                        </div>
                        <div class="mb-0">
                            <label for="service_name" class="form-label fw-semibold">Service associé</label>
                            <input type="text" name="service_name" id="service_name" class="form-control" 
                                   placeholder="Nom du service lié..."
                                   value="<?= htmlspecialchars($formation['service_name'] ?? '') ?>">
                        </div>
                    </div>
                </div>

                <!-- Image -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-image-fill text-success"></i> Image
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="imagePreview" class="mb-3 text-center">
                            <?php if (!empty($formation['image'])): ?>
                                <img src="<?= htmlspecialchars($formation['image']) ?>" 
                                     class="img-fluid rounded" style="max-height: 200px;" alt="">
                            <?php else: ?>
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 120px;">
                                    <div class="text-center text-muted">
                                        <i class="bi bi-image display-4"></i>
                                        <p class="small mb-0">Aucune image</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <input type="file" name="image_file" class="form-control mb-2" accept="image/*">
                        <label class="form-label small">Ou URL :</label>
                        <input type="text" name="image_url" class="form-control form-control-sm" 
                               placeholder="https://..."
                               value="<?= htmlspecialchars($formation['image'] ?? '') ?>">
                    </div>
                </div>

                <!-- Danger zone -->
                <?php if ($formation): ?>
                    <div class="card border-danger border-opacity-25 mb-4">
                        <div class="card-header bg-danger bg-opacity-10 border-0">
                            <h5 class="card-title mb-0 text-danger">
                                <i class="bi bi-exclamation-triangle-fill"></i> Zone de danger
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="small text-muted mb-2">Supprime la formation, ses modules, leçons et inscriptions.</p>
                            <form method="POST" action="/admin/formations/delete/<?= $formation['id'] ?>"
                                  onsubmit="return confirm('Supprimer définitivement cette formation et tout son contenu ?')">
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                    <i class="bi bi-trash"></i> Supprimer la formation
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </form>
</div>

<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
    selector: '#description',
    height: 500,
    language: 'fr_FR',
    plugins: [
        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
        'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
        'insertdatetime', 'media', 'table', 'help', 'wordcount', 'codesample'
    ],
    toolbar: 'undo redo | blocks | bold italic forecolor | ' +
             'alignleft aligncenter alignright | bullist numlist outdent indent | ' +
             'link image media table | codesample | removeformat | fullscreen code',
    content_style: 'body { font-family: Inter, -apple-system, sans-serif; font-size: 16px; line-height: 1.7; max-width: 800px; margin: 0 auto; padding: 20px; }',
    promotion: false,
    branding: false,
    setup: function(editor) {
        editor.on('change', function() { editor.save(); });
    }
});

// Compteurs SEO
function updateCounters() {
    var mt = document.getElementById('meta_title');
    var md = document.getElementById('meta_description');
    if (mt) {
        var l = mt.value.length;
        document.getElementById('metaTitleCount').textContent = l + '/60';
        document.getElementById('metaTitleCount').className = 'seo-counter ' + (l > 60 ? 'text-danger' : l > 50 ? 'text-warning' : 'text-success');
    }
    if (md) {
        var l = md.value.length;
        document.getElementById('metaDescCount').textContent = l + '/160';
        document.getElementById('metaDescCount').className = 'seo-counter ' + (l > 160 ? 'text-danger' : l > 140 ? 'text-warning' : 'text-success');
    }
}
document.getElementById('meta_title').addEventListener('input', updateCounters);
document.getElementById('meta_description').addEventListener('input', updateCounters);
updateCounters();
</script>
