<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Digita Marketing - Agence Marketing Digital, Automatisation & IA' ?></title>
    <link rel="icon" type="image/png" href="/assets/images/digita.png">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?= htmlspecialchars($metaDescription ?? 'Digita Marketing : agence spécialisée en marketing digital, automatisation et intelligence artificielle à La Réunion. Formations, services et solutions sur mesure.') ?>">
    <meta name="keywords" content="<?= htmlspecialchars($metaKeywords ?? 'marketing digital, automatisation, intelligence artificielle, IA, formation, SEO, La Réunion') ?>">
    <meta name="author" content="Digita Marketing">
    <meta name="robots" content="<?= $metaRobots ?? 'index, follow' ?>">
    <?php 
    $canonicalUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'digita.tonyalpha80.com') . strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
    if (isset($canonical)) $canonicalUrl = $canonical;
    ?>
    <link rel="canonical" href="<?= htmlspecialchars($canonicalUrl) ?>">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="<?= $ogType ?? 'website' ?>">
    <meta property="og:url" content="<?= htmlspecialchars($canonicalUrl) ?>">
    <meta property="og:title" content="<?= htmlspecialchars($ogTitle ?? $title ?? 'Digita Marketing') ?>">
    <meta property="og:description" content="<?= htmlspecialchars($ogDescription ?? $metaDescription ?? 'Digita Marketing : agence spécialisée en marketing digital, automatisation et intelligence artificielle à La Réunion.') ?>">
    <meta property="og:image" content="<?= htmlspecialchars($ogImage ?? ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'digita.tonyalpha80.com') . '/assets/images/digita.png')) ?>">
    <meta property="og:site_name" content="Digita Marketing">
    <meta property="og:locale" content="fr_FR">
    
    <!-- Twitter Cards -->
    <meta name="twitter:card" content="<?= $twitterCard ?? 'summary_large_image' ?>">
    <meta name="twitter:title" content="<?= htmlspecialchars($ogTitle ?? $title ?? 'Digita Marketing') ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($ogDescription ?? $metaDescription ?? 'Digita Marketing : agence spécialisée en marketing digital, automatisation et intelligence artificielle à La Réunion.') ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($ogImage ?? ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'digita.tonyalpha80.com') . '/assets/images/digita.png')) ?>">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts Premium -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS Principal -->
    <link rel="stylesheet" href="/assets/css/style.css">
    
    <!-- CSS Global Layout -->
    <link rel="stylesheet" href="/assets/css/global-layout.css?v=<?= time() ?>">
    
    <!-- CSS Composants Réutilisables -->
    <link rel="stylesheet" href="/assets/css/components.css?v=<?= time() ?>">
    
    <!-- CSS Spécifique aux pages (optionnel) - EN DERNIER pour priorité -->
    <?php if (isset($extraCss)): ?>
        <?php foreach ($extraCss as $css): ?>
            <link rel="stylesheet" href="<?= $css ?>?v=<?= time() ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
    
    <!-- GLightbox CSS -->
    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">
    
    <!-- Swiper CSS -->
    <link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet">
    
    <!-- Schema.org Organization (toutes les pages) -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "Digita Marketing",
        "url": "<?= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'digita.tonyalpha80.com') ?>",
        "logo": "<?= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'digita.tonyalpha80.com') ?>/assets/images/digita.png",
        "description": "Agence spécialisée en marketing digital, automatisation et intelligence artificielle à La Réunion.",
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "La Réunion",
            "addressCountry": "FR"
        },
        "sameAs": []
    }
    </script>
    
    <?php if (isset($schemaType) && $schemaType === 'article' && isset($schemaData)): ?>
    <!-- Schema.org Article -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Article",
        "headline": "<?= htmlspecialchars($schemaData['meta_title'] ?? $schemaData['title'] ?? '') ?>",
        "description": "<?= htmlspecialchars($schemaData['meta_description'] ?? '') ?>",
        <?php if (!empty($schemaData['featured_image'])): ?>
        "image": "<?= htmlspecialchars($schemaData['featured_image']) ?>",
        <?php endif; ?>
        "author": {
            "@type": "Organization",
            "name": "Digita Marketing"
        },
        "publisher": {
            "@type": "Organization",
            "name": "Digita Marketing",
            "logo": {
                "@type": "ImageObject",
                "url": "<?= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'digita.tonyalpha80.com') ?>/assets/images/digita.png"
            }
        },
        "datePublished": "<?= $schemaData['published_at'] ?? $schemaData['created_at'] ?? '' ?>",
        "dateModified": "<?= $schemaData['updated_at'] ?? $schemaData['published_at'] ?? $schemaData['created_at'] ?? '' ?>",
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "<?= htmlspecialchars($canonicalUrl ?? '') ?>"
        }
    }
    </script>
    <?php endif; ?>
    
    <?php if (isset($schemaType) && $schemaType === 'course' && isset($schemaData)): ?>
    <!-- Schema.org Course -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Course",
        "name": "<?= htmlspecialchars($schemaData['title'] ?? '') ?>",
        "description": "<?= htmlspecialchars($schemaData['meta_description'] ?? mb_strimwidth(strip_tags($schemaData['description'] ?? ''), 0, 155, '...')) ?>",
        "provider": {
            "@type": "Organization",
            "name": "Digita Marketing"
        },
        <?php if (!empty($schemaData['image'])): ?>
        "image": "<?= htmlspecialchars($schemaData['image']) ?>",
        <?php endif; ?>
        "educationalLevel": "<?= htmlspecialchars($schemaData['level'] ?? 'debutant') ?>",
        <?php if (isset($schemaData['price']) && $schemaData['price'] > 0): ?>
        "offers": {
            "@type": "Offer",
            "price": "<?= $schemaData['price'] ?>",
            "priceCurrency": "EUR",
            "availability": "https://schema.org/InStock"
        },
        <?php else: ?>
        "isAccessibleForFree": true,
        <?php endif; ?>
        "inLanguage": "fr"
    }
    </script>
    <?php endif; ?>
    
    <?php if (isset($breadcrumbs) && !empty($breadcrumbs)): ?>
    <!-- Schema.org BreadcrumbList -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            <?php foreach ($breadcrumbs as $i => $crumb): ?>
            {
                "@type": "ListItem",
                "position": <?= $i + 1 ?>,
                "name": "<?= htmlspecialchars($crumb['name']) ?>",
                "item": "<?= htmlspecialchars($crumb['url']) ?>"
            }<?= $i < count($breadcrumbs) - 1 ? ',' : '' ?>
            <?php endforeach; ?>
        ]
    }
    </script>
    <?php endif; ?>
    
    <?php if (isset($faqSchema) && !empty($faqSchema)): ?>
    <!-- Schema.org FAQPage -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": [
            <?php foreach ($faqSchema as $fi => $faq): ?>
            {
                "@type": "Question",
                "name": "<?= htmlspecialchars($faq['question']) ?>",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "<?= htmlspecialchars($faq['answer']) ?>"
                }
            }<?= $fi < count($faqSchema) - 1 ? ',' : '' ?>
            <?php endforeach; ?>
        ]
    }
    </script>
    <?php endif; ?>
</head>
<body>
    <?php 
    $projectRoot = dirname(dirname(dirname(__DIR__)));
    require_once $projectRoot . '/includes/partials/sidebar-onglet.php'; 
    require_once $projectRoot . '/includes/partials/navbar.php'; 
    require_once $projectRoot . '/includes/partials/sidebar-agence.php'; 
    ?>
    
    <!-- Chatbot -->
    <div id="chatbot-container">
        <button id="chatbot-button" onclick="toggleChatbot()">
            <i class="bi bi-chat-dots-fill"></i>
        </button>
        <div id="chatbot-window">
            <div id="chatbot-header">
                <h5>💬 Assistant Digita</h5>
                <button id="chatbot-close" onclick="toggleChatbot()">×</button>
            </div>
            <div id="chatbot-messages"></div>
            <div id="chatbot-input-container">
                <input type="text" id="chatbot-input" placeholder="Posez votre question..." onkeypress="if(event.key==='Enter') sendMessage()">
                <button id="chatbot-send" onclick="sendMessage()">
                    <i class="bi bi-send-fill"></i>
                </button>
            </div>
        </div>
    </div>
    
    <main>
        <?php if (isset($breadcrumbs) && !empty($breadcrumbs)): ?>
        <div class="breadcrumb-wrapper">
            <div class="container">
                <nav aria-label="Fil d'Ariane">
                    <ol class="breadcrumb mb-0 py-2">
                        <?php foreach ($breadcrumbs as $i => $crumb): ?>
                            <?php if ($i === count($breadcrumbs) - 1): ?>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <?= htmlspecialchars(mb_strimwidth($crumb['name'], 0, 50, '...')) ?>
                                </li>
                            <?php else: ?>
                                <li class="breadcrumb-item">
                                    <a href="<?= htmlspecialchars($crumb['url']) ?>"><?= htmlspecialchars($crumb['name']) ?></a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ol>
                </nav>
            </div>
        </div>
        <?php endif; ?>
        <?= $content ?>
    </main>
    
    <!-- Composants de Conversion Premium -->
    <?php require_once $projectRoot . '/app/Views/components/conversion-modal.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/isotope-layout@3.0.6/dist/isotope.pkgd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <?php if (isset($extraJs)): ?>
        <?php foreach ($extraJs as $js): ?>
            <script src="<?= $js ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <script>AOS.init({ duration: 700, once: true });</script>
    
    <!-- Scripts Chatbot IA -->
    <script>
        const chatSessionId = 'chat_' + Math.random().toString(36).substr(2, 9) + '_' + Date.now();
        
        function toggleChatbot() {
            const chatbotWindow = document.getElementById('chatbot-window');
            if (chatbotWindow) {
                chatbotWindow.classList.toggle('active');
            }
        }
        
        function sendMessage() {
            const input = document.getElementById('chatbot-input');
            const messagesContainer = document.getElementById('chatbot-messages');
            
            if (input && input.value.trim() !== '') {
                const userText = input.value.trim();
                
                const userMessage = document.createElement('div');
                userMessage.className = 'chat-message user';
                userMessage.innerHTML = '<div class="message-content">' + escapeHtml(userText) + '</div>';
                messagesContainer.appendChild(userMessage);
                input.value = '';
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
                
                const typing = document.createElement('div');
                typing.className = 'chat-message bot';
                typing.id = 'typing-indicator';
                typing.innerHTML = '<div class="message-content"><em>En train d\'écrire...</em></div>';
                messagesContainer.appendChild(typing);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
                
                fetch('/api/chatbot/message', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: 'message=' + encodeURIComponent(userText) + '&session_id=' + chatSessionId + '&page=' + encodeURIComponent(window.location.pathname)
                })
                .then(r => r.json())
                .then(data => {
                    const t = document.getElementById('typing-indicator');
                    if (t) t.remove();
                    
                    if (data.success && data.reply) {
                        const botMessage = document.createElement('div');
                        botMessage.className = 'chat-message bot';
                        botMessage.innerHTML = '<div class="message-content">' + escapeHtml(data.reply) + '</div>';
                        messagesContainer.appendChild(botMessage);
                    }
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                })
                .catch(() => {
                    const t = document.getElementById('typing-indicator');
                    if (t) t.remove();
                    
                    const errMsg = document.createElement('div');
                    errMsg.className = 'chat-message bot';
                    errMsg.innerHTML = '<div class="message-content">Désolé, une erreur est survenue. Contactez-nous via <a href="/contact">/contact</a>.</div>';
                    messagesContainer.appendChild(errMsg);
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                });
            }
        }
        
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    </script>
    
    <!-- Note: Les fonctions ouvrirSidebarAgence() et fermerSidebarAgence() sont définies dans sidebar-agence.php -->
</body>
</html>
