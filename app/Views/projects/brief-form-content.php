<!-- Formulaire de Brief Client - Multi-étapes -->
<section class="brief-page" style="padding-top: 120px; padding-bottom: 60px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <h1 class="display-5 fw-bold">Créez votre projet digital</h1>
                    <p class="lead text-muted">Décrivez votre besoin et recevez un devis instantané</p>
                </div>

                <?php if (!empty($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?= htmlspecialchars($_SESSION['error_message']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['error_message']); ?>
                <?php endif; ?>

                <!-- Indicateur d'étapes -->
                <div class="d-flex justify-content-center mb-5">
                    <div class="step-indicator d-flex align-items-center gap-2">
                        <span class="step-dot active" data-step="1">1</span>
                        <span class="step-line"></span>
                        <span class="step-dot" data-step="2">2</span>
                        <span class="step-line"></span>
                        <span class="step-dot" data-step="3">3</span>
                    </div>
                </div>

                <form action="/projets/brief" method="POST" id="briefForm">
                    <!-- Étape 1 : Type de projet -->
                    <div class="brief-step" id="step1">
                        <h3 class="mb-4"><i class="bi bi-1-circle text-primary"></i> Type de projet</h3>
                        
                        <div class="row g-3 mb-4">
                            <?php
                            $icons = [
                                'website' => 'bi-globe',
                                'ecommerce' => 'bi-cart3',
                                'landing' => 'bi-file-earmark-richtext',
                                'app' => 'bi-phone',
                                'seo' => 'bi-search',
                                'marketing' => 'bi-megaphone'
                            ];
                            foreach ($projectTypes as $key => $label):
                            ?>
                                <div class="col-md-4 col-6">
                                    <input type="radio" name="project_type" value="<?= $key ?>" id="type_<?= $key ?>" class="btn-check" required>
                                    <label class="btn btn-outline-primary w-100 py-3 text-center" for="type_<?= $key ?>">
                                        <i class="bi <?= $icons[$key] ?? 'bi-folder' ?> fs-3 d-block mb-2"></i>
                                        <?= htmlspecialchars($label) ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">Nom du projet *</label>
                            <input type="text" name="title" id="title" class="form-control form-control-lg" placeholder="Ex: Site vitrine pour mon restaurant" required>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-primary btn-lg" onclick="nextStep(2)">
                                Suivant <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Étape 2 : Détails du brief -->
                    <div class="brief-step d-none" id="step2">
                        <h3 class="mb-4"><i class="bi bi-2-circle text-primary"></i> Détails du projet</h3>

                        <div class="mb-3">
                            <label for="business_name" class="form-label fw-bold">Nom de l'entreprise</label>
                            <input type="text" name="business_name" id="business_name" class="form-control" placeholder="Votre entreprise">
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="business_type" class="form-label fw-bold">Secteur d'activité</label>
                                <select name="business_type" id="business_type" class="form-select">
                                    <option value="">Sélectionner...</option>
                                    <option value="restaurant">Restaurant / Hôtellerie</option>
                                    <option value="commerce">Commerce / Retail</option>
                                    <option value="services">Services / Conseil</option>
                                    <option value="sante">Santé / Bien-être</option>
                                    <option value="immobilier">Immobilier</option>
                                    <option value="tech">Tech / Startup</option>
                                    <option value="artisan">Artisanat / BTP</option>
                                    <option value="education">Éducation / Formation</option>
                                    <option value="autre">Autre</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="target_audience" class="form-label fw-bold">Public cible</label>
                                <input type="text" name="target_audience" id="target_audience" class="form-control" placeholder="Ex: Particuliers 25-45 ans">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="brief" class="form-label fw-bold">Décrivez votre projet *</label>
                            <textarea name="brief" id="brief" class="form-control" rows="5" placeholder="Décrivez en détail ce que vous souhaitez : objectifs, fonctionnalités, inspirations..." required></textarea>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="existing_url" class="form-label fw-bold">Site existant (si applicable)</label>
                                <input type="url" name="existing_url" id="existing_url" class="form-control" placeholder="https://...">
                            </div>
                            <div class="col-md-6">
                                <label for="competitors" class="form-label fw-bold">Sites concurrents / inspirations</label>
                                <input type="text" name="competitors" id="competitors" class="form-control" placeholder="URLs séparées par des virgules">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-outline-secondary btn-lg" onclick="nextStep(1)">
                                <i class="bi bi-arrow-left"></i> Retour
                            </button>
                            <button type="button" class="btn btn-primary btn-lg" onclick="nextStep(3)">
                                Suivant <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Étape 3 : Options & Devis -->
                    <div class="brief-step d-none" id="step3">
                        <h3 class="mb-4"><i class="bi bi-3-circle text-primary"></i> Options & Devis</h3>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label for="style" class="form-label fw-bold">Style visuel</label>
                                <select name="style" id="style" class="form-select">
                                    <option value="modern">Moderne</option>
                                    <option value="minimal">Minimaliste</option>
                                    <option value="corporate">Corporate</option>
                                    <option value="creative">Créatif</option>
                                    <option value="elegant">Élégant</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="pages" class="form-label fw-bold">Nombre de pages</label>
                                <input type="number" name="pages" id="pages" class="form-control" value="5" min="1" max="50">
                            </div>
                            <div class="col-md-4">
                                <label for="content_tone" class="form-label fw-bold">Ton du contenu</label>
                                <select name="content_tone" id="content_tone" class="form-select">
                                    <option value="professionnel">Professionnel</option>
                                    <option value="decontracte">Décontracté</option>
                                    <option value="luxe">Luxe / Premium</option>
                                    <option value="dynamique">Dynamique</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Fonctionnalités souhaitées</label>
                            <div class="row g-2">
                                <?php
                                $features = [
                                    'contact_form' => 'Formulaire de contact',
                                    'blog' => 'Blog / Actualités',
                                    'gallery' => 'Galerie photos',
                                    'booking' => 'Réservation en ligne',
                                    'newsletter' => 'Newsletter',
                                    'social' => 'Réseaux sociaux',
                                    'maps' => 'Carte Google Maps',
                                    'chat' => 'Chat en ligne',
                                    'multilingual' => 'Multilingue',
                                    'analytics' => 'Analytics / Statistiques'
                                ];
                                foreach ($features as $fKey => $fLabel):
                                ?>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="features[]" value="<?= $fKey ?>" id="feat_<?= $fKey ?>">
                                            <label class="form-check-label" for="feat_<?= $fKey ?>"><?= $fLabel ?></label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="colors" class="form-label fw-bold">Couleurs préférées</label>
                                <input type="text" name="colors" id="colors" class="form-control" placeholder="Ex: bleu, blanc, gris">
                            </div>
                            <div class="col-md-6">
                                <label for="deadline" class="form-label fw-bold">Délai souhaité</label>
                                <select name="deadline" id="deadline" class="form-select">
                                    <option value="">Pas de contrainte</option>
                                    <option value="1week">1 semaine</option>
                                    <option value="2weeks">2 semaines</option>
                                    <option value="1month">1 mois</option>
                                    <option value="3months">3 mois</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="urgent" id="urgent" value="1">
                            <label class="form-check-label" for="urgent">
                                <i class="bi bi-lightning-charge text-warning"></i> Projet urgent (livraison accélérée, +50%)
                            </label>
                        </div>

                        <!-- Devis estimé -->
                        <div class="card bg-primary bg-opacity-10 border-primary mb-4">
                            <div class="card-body text-center">
                                <h5 class="text-primary mb-1">Devis estimé</h5>
                                <div class="display-4 fw-bold text-primary" id="quotePrice">—</div>
                                <small class="text-muted">Ce prix est indicatif et sera confirmé après étude de votre brief</small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-outline-secondary btn-lg" onclick="nextStep(2)">
                                <i class="bi bi-arrow-left"></i> Retour
                            </button>
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-send"></i> Soumettre mon projet
                                </button>
                            <?php else: ?>
                                <a href="/connexion" class="btn btn-success btn-lg">
                                    <i class="bi bi-box-arrow-in-right"></i> Connectez-vous pour soumettre
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
function nextStep(step) {
    document.querySelectorAll('.brief-step').forEach(s => s.classList.add('d-none'));
    document.getElementById('step' + step).classList.remove('d-none');
    document.querySelectorAll('.step-dot').forEach(d => {
        d.classList.toggle('active', parseInt(d.dataset.step) <= step);
    });
    if (step === 3) updateQuote();
    window.scrollTo({top: 0, behavior: 'smooth'});
}

function updateQuote() {
    const type = document.querySelector('input[name="project_type"]:checked');
    if (!type) return;
    const pages = document.getElementById('pages').value || 5;
    const urgent = document.getElementById('urgent').checked ? 1 : 0;
    const multilingual = document.getElementById('feat_multilingual') && document.getElementById('feat_multilingual').checked ? 1 : 0;

    fetch('/api/project-quote', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'project_type=' + type.value + '&pages=' + pages + '&urgent=' + urgent + '&multilingual=' + multilingual
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.getElementById('quotePrice').textContent = data.formatted;
        }
    });
}

document.getElementById('pages').addEventListener('change', updateQuote);
document.getElementById('urgent').addEventListener('change', updateQuote);
document.querySelectorAll('input[name="project_type"]').forEach(r => r.addEventListener('change', updateQuote));
</script>
