<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Admin' ?> - Digita Marketing</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Custom Admin CSS -->
    <link rel="stylesheet" href="/assets/css/admin/dashboard.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-gradient">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center" href="/admin/dashboard">
                <i class="bi bi-lightning-charge-fill me-2"></i>
                <span class="fw-bold">Digita Marketing</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= ($pageTitle === 'Dashboard') ? 'active' : '' ?>" href="/admin/dashboard">
                            <i class="bi bi-grid-fill"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($pageTitle === 'Messages de contact') ? 'active' : '' ?>" href="/admin/contacts">
                            <i class="bi bi-envelope-fill"></i> Messages
                            <?php if (isset($stats['contacts']['new']) && $stats['contacts']['new'] > 0): ?>
                                <span class="badge bg-danger ms-1"><?= $stats['contacts']['new'] ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($pageTitle === 'Abonnés newsletter') ? 'active' : '' ?>" href="/admin/newsletters">
                            <i class="bi bi-newspaper"></i> Newsletter
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/webhooks">
                            <i class="bi bi-bell-fill"></i> Webhooks
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/campaigns">
                            <i class="bi bi-megaphone-fill"></i> Campagnes
                        </a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center gap-3">
                    <div class="user-info text-white-50 small d-none d-md-block">
                        <i class="bi bi-person-circle"></i>
                        <?= htmlspecialchars($currentUser['email'] ?? 'Admin') ?>
                    </div>
                    <a href="/" class="btn btn-outline-light btn-sm" target="_blank">
                        <i class="bi bi-house-fill"></i> Site
                    </a>
                    <a href="/admin/logout" class="btn btn-danger btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Déconnexion
                    </a>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main class="main-content">
        <?php 
        // Charger la vue de contenu
        if (isset($contentView)) {
            require __DIR__ . '/../' . $contentView . '.php';
        }
        ?>
    </main>
    
    <!-- Footer -->
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container-fluid px-4">
            <div class="row">
                <div class="col-md-6">
                    <span class="text-muted">© <?= date('Y') ?> Digita Marketing. Tous droits réservés.</span>
                </div>
                <div class="col-md-6 text-md-end">
                    <span class="text-muted">Version 2.0 - Architecture MVC</span>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Admin JS -->
    <script src="/assets/js/admin/dashboard.js"></script>
</body>
</html>
