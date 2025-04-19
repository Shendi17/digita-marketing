<?php
require_once __DIR__ . '/../config/config.php';

// Récupération des données de la page depuis le cache
$cache = new Cache();
$about_data = $cache->get('about_page_data');

if ($about_data === false) {
    // Si pas en cache, on récupère depuis la base de données
    $db = Database::getInstance();
    try {
        $about_data = [
            'histoire' => $db->fetch("SELECT * FROM content WHERE page = 'about' AND section = 'histoire'"),
            'valeurs' => $db->fetchAll("SELECT * FROM content WHERE page = 'about' AND section = 'valeurs'"),
            'equipe' => $db->fetchAll("SELECT * FROM team_members WHERE active = 1 ORDER BY ordre")
        ];
        // Mise en cache pour 1 heure
        $cache->set('about_page_data', $about_data);
    } catch (Exception $e) {
        // En cas d'erreur, utiliser des données par défaut
        $about_data = [
            'histoire' => [
                'titre' => 'Notre Histoire',
                'contenu' => 'Depuis 2015, DIGITA accompagne les entreprises dans leur transformation digitale.'
            ],
            'valeurs' => [],
            'equipe' => []
        ];
    }
}
?>

<div class="page-header bg-primary text-white py-5 mb-5">
    <div class="container">
        <h1 class="display-4">À propos de DIGITA</h1>
        <p class="lead">Une agence digitale innovante au service de votre succès</p>
    </div>
</div>

<div class="container">
    <!-- Notre Histoire -->
    <div class="row mb-5 align-items-center">
        <div class="col-md-6">
            <h2><?php echo htmlspecialchars($about_data['histoire']['titre']); ?></h2>
            <p class="lead"><?php echo htmlspecialchars($about_data['histoire']['contenu']); ?></p>
        </div>
        <div class="col-md-6">
            <img src="<?php echo SITE_URL; ?>/assets/images/about/history.jpg" alt="Notre Histoire" class="img-fluid rounded shadow">
        </div>
    </div>

    <!-- Nos Valeurs -->
    <?php if (!empty($about_data['valeurs'])): ?>
    <div class="row mb-5">
        <div class="col-12 text-center mb-4">
            <h2>Nos Valeurs</h2>
            <p class="lead">Ce qui nous définit et guide nos actions au quotidien</p>
        </div>
        <?php foreach ($about_data['valeurs'] as $valeur): ?>
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas <?php echo htmlspecialchars($valeur['icone']); ?> fa-3x mb-3 text-primary"></i>
                    <h4 class="card-title"><?php echo htmlspecialchars($valeur['titre']); ?></h4>
                    <p class="card-text"><?php echo htmlspecialchars($valeur['description']); ?></p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Notre Équipe -->
    <?php if (!empty($about_data['equipe'])): ?>
    <div class="team-section mb-5">
        <div class="text-center mb-4">
            <h2>Notre Équipe</h2>
            <p class="lead">Des experts passionnés à votre service</p>
        </div>
        <div class="row">
            <?php foreach ($about_data['equipe'] as $membre): ?>
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm">
                    <img src="<?php echo SITE_URL; ?>/assets/images/team/<?php echo htmlspecialchars($membre['photo']); ?>" 
                         class="card-img-top" 
                         alt="<?php echo htmlspecialchars($membre['nom']); ?>">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-1"><?php echo htmlspecialchars($membre['nom']); ?></h5>
                        <p class="text-muted"><?php echo htmlspecialchars($membre['poste']); ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>
