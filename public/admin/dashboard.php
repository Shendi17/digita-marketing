<?php
// Redirection vers le nouveau dashboard MVC
require_once __DIR__ . '/../../config/config.php';
header('Location: ' . SITE_URL . '/admin/dashboard');
exit();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Digita Marketing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/dashboard.css">
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
                        <a class="nav-link active" href="dashboard.php">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="webhooks.php">
                            <i class="bi bi-bell"></i> Notifications
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="campaigns.php">
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
        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Actions rapides</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <a href="campaigns.php?action=new" class="btn btn-outline-primary w-100">
                            <i class="bi bi-plus-circle"></i> Nouvelle campagne
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="tasks.php?action=new" class="btn btn-outline-primary w-100">
                            <i class="bi bi-plus-circle"></i> Nouvelle tâche
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="webhooks.php" class="btn btn-outline-primary w-100">
                            <i class="bi bi-gear"></i> Configurer webhooks
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="reports.php" class="btn btn-outline-primary w-100">
                            <i class="bi bi-file-earmark-text"></i> Voir les rapports
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <h5 class="card-title text-primary">
                            <i class="bi bi-eye"></i> Visites
                        </h5>
                        <h3><?php echo number_format($stats['visits']); ?></h3>
                        <p class="text-muted mb-0">Ce mois-ci</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <h5 class="card-title text-success">
                            <i class="bi bi-person"></i> Contacts
                        </h5>
                        <h3><?php echo number_format($stats['contacts']); ?></h3>
                        <p class="text-muted mb-0">Nouveaux leads</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <h5 class="card-title text-info">
                            <i class="bi bi-megaphone"></i> Campagnes
                        </h5>
                        <h3><?php echo number_format($stats['campaigns']); ?></h3>
                        <p class="text-muted mb-0">En cours</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <h5 class="card-title text-warning">
                            <i class="bi bi-list-check"></i> Tâches
                        </h5>
                        <h3><?php echo number_format($stats['tasks']); ?></h3>
                        <p class="text-muted mb-0">À faire</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Recent Activity -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Activités récentes</h5>
                        <a href="activities.php" class="btn btn-sm btn-outline-primary">Voir tout</a>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Nouvelle campagne créée</h6>
                                    <small class="text-muted">Il y a 3 heures</small>
                                </div>
                                <p class="mb-1">Campagne "Soldes d'été 2025" créée</p>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Contact reçu</h6>
                                    <small class="text-muted">Il y a 5 heures</small>
                                </div>
                                <p class="mb-1">Nouveau message de contact@example.com</p>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Tâche terminée</h6>
                                    <small class="text-muted">Il y a 1 jour</small>
                                </div>
                                <p class="mb-1">Mise à jour du site web terminée</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tasks -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Tâches à faire</h5>
                        <a href="tasks.php" class="btn btn-sm btn-outline-primary">Voir tout</a>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="task1">
                                    <label class="form-check-label" for="task1">
                                        Préparer le rapport mensuel
                                        <span class="badge bg-warning text-dark ms-2">Prioritaire</span>
                                    </label>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="task2">
                                    <label class="form-check-label" for="task2">
                                        Répondre aux messages clients
                                        <span class="badge bg-info ms-2">En cours</span>
                                    </label>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="task3">
                                    <label class="form-check-label" for="task3">
                                        Mettre à jour les réseaux sociaux
                                        <span class="badge bg-success ms-2">Planifié</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Calendar Preview -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Calendrier</h5>
                        <a href="calendar.php" class="btn btn-sm btn-outline-primary">Voir tout</a>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Réunion d'équipe</h6>
                                    <small class="text-muted">Aujourd'hui 14:00</small>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Lancement campagne</h6>
                                    <small class="text-muted">Demain 10:00</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
