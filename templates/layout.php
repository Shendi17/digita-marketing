<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'DIGITA | Cabinet de Conseil Strategic & IA' ?></title>
    
    <!-- Google Fonts Premium (Outfit & Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 (Ultra Clean Version) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- CSS Principal & Global -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/global-layout.css">
    
    <?php if (isset($extraCss)) foreach ($extraCss as $css): ?>
        <link rel="stylesheet" href="<?= $css ?>">
    <?php endforeach; ?>

    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet">
    
    <style>
        :root {
            --font-heading: 'Outfit', sans-serif;
            --font-body: 'Inter', sans-serif;
            --main-sidebar-width: 260px;
        }
        body {
            font-family: var(--font-body);
            background-color: var(--dark, #050505);
            color: #fff;
        }
        .main-container-premium {
            margin-left: var(--main-sidebar-width);
            min-height: 100vh;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: #050505;
            position: relative;
            overflow-x: hidden;
        }
        @media (max-width: 991px) {
            .main-container-premium {
                margin-left: 0;
            }
        }
        /* Ensure rounded corners on any card or section are crisp */
        .glass-card, .service-card-premium, .problem-card {
            border-radius: 20px !important;
            overflow: hidden;
        }
    </style>
</head>
<body class="premium-layout">
    <!-- Navigation Latérale Premium -->
    <?php require_once __DIR__ . '/../includes/partials/sidebar-premium.php'; ?>
    
    <div class="main-container-premium">
        <main>
            <?= $content ?? '' ?>
        </main>
        
        <!-- Nouveau Footer Premium (Consolidé) -->
        <?php require_once __DIR__ . '/../includes/partials/footer-premium.php'; ?>
    </div>

    <!-- Scripts Global Plugins -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <?php if (isset($extraJs)) foreach ($extraJs as $js): ?>
        <script src="<?= $js ?>"></script>
    <?php endforeach; ?>
    
    <script>
        AOS.init({ duration: 800, once: true });
    </script>
</body>
</html>
