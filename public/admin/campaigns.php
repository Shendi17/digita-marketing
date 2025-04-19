<?php
require_once __DIR__ . '/../../src/includes/config.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

// Données factices pour la démo
$campaigns = [
    [
        'id' => 1,
        'name' => 'Soldes d\'été 2025',
        'status' => 'active',
        'start_date' => '2025-06-01',
        'end_date' => '2025-07-31',
        'budget' => 5000,
        'progress' => 65
    ],
    [
        'id' => 2,
        'name' => 'Black Friday 2024',
        'status' => 'completed',
        'start_date' => '2024-11-24',
        'end_date' => '2024-11-27',
        'budget' => 3000,
        'progress' => 100
    ],
    [
        'id' => 3,
        'name' => 'Lancement Produit X',
        'status' => 'draft',
        'start_date' => '2025-03-15',
        'end_date' => '2025-04-15',
        'budget' => 7500,
        'progress' => 0
    ]
];

$action = $_GET['action'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campagnes - Digita Marketing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .navbar-brand {
            font-weight: bold;
            color: #2563EB !important;
        }
        .nav-link {
            color: #1F2937;
            padding: 0.5rem 1rem;
            margin: 0.2rem 0;
            border-radius: 0.375rem;
        }
        .nav-link:hover {
            background-color: #F3F4F6;
            color: #2563EB;
        }
        .nav-link.active {
            background-color: #EFF6FF;
            color: #2563EB;
            font-weight: 500;
        }
        .campaign-card {
            border: 1px solid #E5E7EB;
            border-radius: 0.5rem;
            transition: transform 0.2s;
        }
        .campaign-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Digita Marketing</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="webhooks.php">
                            <i class="bi bi-bell"></i> Notifications
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="campaigns.php">
                            <i class="bi bi-megaphone"></i> Campagnes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="tasks.php">
                            <i class="bi bi-list-check"></i> Tâches
                        </a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="/" class="btn btn-outline-primary me-2">
                        <i class="bi bi-house"></i> Site public
                    </a>
                    <a href="logout.php" class="btn btn-danger">
                        <i class="bi bi-box-arrow-right"></i> Déconnexion
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <?php if ($action === 'new'): ?>
            <!-- Formulaire de nouvelle campagne -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Nouvelle campagne</h5>
                </div>
                <div class="card-body">
                    <form action="campaigns.php" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nom de la campagne</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Budget (€)</label>
                                <input type="number" class="form-control" name="budget" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date de début</label>
                                <input type="date" class="form-control" name="start_date" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date de fin</label>
                                <input type="date" class="form-control" name="end_date" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="4"></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Objectifs</label>
                                <select class="form-select" name="objectives[]" multiple>
                                    <option value="awareness">Notoriété</option>
                                    <option value="traffic">Trafic</option>
                                    <option value="leads">Leads</option>
                                    <option value="sales">Ventes</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Canaux</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="channels[]" value="social">
                                    <label class="form-check-label">Réseaux sociaux</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="channels[]" value="email">
                                    <label class="form-check-label">Email</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="channels[]" value="search">
                                    <label class="form-check-label">Google Ads</label>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <a href="campaigns.php" class="btn btn-light me-2">Annuler</a>
                            <button type="submit" class="btn btn-primary">Créer la campagne</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <!-- Liste des campagnes -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Campagnes marketing</h2>
                <a href="?action=new" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Nouvelle campagne
                </a>
            </div>

            <div class="row g-4">
                <?php foreach ($campaigns as $campaign): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card campaign-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title mb-0"><?php echo htmlspecialchars($campaign['name']); ?></h5>
                                    <span class="badge bg-<?php
                                        echo match($campaign['status']) {
                                            'active' => 'success',
                                            'completed' => 'secondary',
                                            'draft' => 'warning'
                                        };
                                    ?>">
                                        <?php echo ucfirst($campaign['status']); ?>
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <div class="text-muted small mb-1">Progression</div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: <?php echo $campaign['progress']; ?>%"
                                             aria-valuenow="<?php echo $campaign['progress']; ?>" aria-valuemin="0" aria-valuemax="100">
                                            <?php echo $campaign['progress']; ?>%
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <div class="text-muted small">Date de début</div>
                                        <div><?php echo $campaign['start_date']; ?></div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-muted small">Date de fin</div>
                                        <div><?php echo $campaign['end_date']; ?></div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="text-muted small">Budget</div>
                                    <div class="h5 mb-0"><?php echo number_format($campaign['budget'], 0, ',', ' '); ?> €</div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <a href="campaign_details.php?id=<?php echo $campaign['id']; ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Voir détails
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
