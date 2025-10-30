<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Digita Marketing' ?></title>
    <link rel="icon" type="image/png" href="/assets/images/digita.png">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
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
        <?= $content ?>
    </main>
    
    <?php require_once $projectRoot . '/includes/partials/footer.php'; ?>
    
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
    
    <!-- Scripts Chatbot -->
    <script>
        // Fonction pour toggle le chatbot
        function toggleChatbot() {
            const chatbotWindow = document.getElementById('chatbot-window');
            if (chatbotWindow) {
                chatbotWindow.classList.toggle('active');
            }
        }
        
        // Fonction pour envoyer un message dans le chatbot
        function sendMessage() {
            const input = document.getElementById('chatbot-input');
            const messagesContainer = document.getElementById('chatbot-messages');
            
            if (input && input.value.trim() !== '') {
                // Message utilisateur
                const userMessage = document.createElement('div');
                userMessage.className = 'chat-message user';
                userMessage.innerHTML = '<div class="message-content">' + input.value + '</div>';
                messagesContainer.appendChild(userMessage);
                
                // Réponse bot (simulation)
                setTimeout(() => {
                    const botMessage = document.createElement('div');
                    botMessage.className = 'chat-message bot';
                    botMessage.innerHTML = '<div class="message-content">Merci pour votre message ! Un conseiller vous répondra bientôt.</div>';
                    messagesContainer.appendChild(botMessage);
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }, 1000);
                
                input.value = '';
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        }
    </script>
    
    <!-- Note: Les fonctions ouvrirSidebarAgence() et fermerSidebarAgence() sont définies dans sidebar-agence.php -->
</body>
</html>
