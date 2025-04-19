<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digita Marketing Digital</title>
    <link rel="icon" type="image/png" href="/digita-marketing/assets/images/logo.png">
    <!-- Correction du chemin CSS pour WAMP/public -->
    <link rel="stylesheet" href="/digita-marketing/assets/css/style.css?v=20250417">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
    <style>
        body { background: #f7f7f7; }
        .hero-bg { background: url('/assets/images/hero-bg.jpg'), linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)); background-size: cover; background-position: center; }
        .hero-arrows { position: absolute; top: 50%; left: 0; width: 100%; display: flex; justify-content: space-between; pointer-events: none; }
        .hero-arrow { font-size: 2.5rem; color: #fff; opacity: 0.7; pointer-events: auto; cursor: pointer; padding: 0 1.5rem; user-select: none; }
        .hero-arrow:hover { opacity: 1; }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/navbar.php'; ?>
    <?php require_once __DIR__ . '/sidebar-agence.php'; ?>
    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 700, once: true });</script>
