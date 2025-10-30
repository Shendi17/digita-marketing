<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digita Marketing Digital</title>
    <link rel="icon" type="image/png" href="/assets/images/digita.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Correction du chemin CSS pour WAMP/public -->
    <link rel="stylesheet" href="/assets/css/style.css?v=20250417">
    <link rel="stylesheet" href="/assets/css/home.css?v=20250417">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Font Awesome désactivé pour test conflit icônes Bootstrap -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> -->
    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
    <style>
        body { background: #f7f7f7; }
        /* Suppression du fond .hero-bg (ancien effet inutilisé) */
        /* .hero-bg { background: url('/assets/images/hero-bg.jpg'), linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)); background-size: cover; background-position: center; } */
        .hero-bg { background: none !important; }
        /* Header/navbar TOUJOURS blanc, même si surcharge Bootstrap ou autres classes */
        .navbar, .navbar.bg-white, .navbar.navbar-light, .navbar.fixed-top {
            background: #fff !important;
            box-shadow: 0 2px 16px #2325260f;
            border-bottom: 1px solid #eee;
        }
        .navbar .nav-link, .navbar .navbar-brand, .navbar .btn {
            color: #232323 !important;
        }
        /* Style des sous-titres de navigation */
        .nav-item {
            text-align: center;
            padding: 0.5rem 1rem;
        }
        .nav-subtitle {
            font-size: 0.75rem;
            color: #666;
            margin-top: -0.25rem;
            white-space: nowrap;
        }
        .nav-link {
            padding: 0.25rem 0.5rem !important;
            font-weight: 500;
        }
        /* Effet hover sur les cartes */
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        }
        /* Compensation pour le header fixe - UNIQUEMENT pour pages articles/formations */
        article.blog-article-page,
        section.formation-detail-page {
            margin-top: 80px !important;
        }
        /* Compensation pour toutes les pages principales (blog, formations, etc.) */
        section.py-5:first-of-type:not(#hero):not(.bg-primary) {
            margin-top: 80px !important;
        }
        /* Protection des couleurs du footer */
        #footer,
        #footer * {
            color: inherit !important;
        }
        #footer h3,
        #footer .footer-info h3 {
            color: #FFD700 !important;
        }
        #footer p,
        #footer strong {
            color: #fff !important;
        }
        #footer .social-links i {
            color: #FFD700 !important;
        }
        .hero-arrows { position: absolute; top: 50%; left: 0; width: 100%; display: flex; justify-content: space-between; pointer-events: none; }
        .hero-arrow { font-size: 2.5rem; color: #fff; opacity: 0.7; pointer-events: auto; cursor: pointer; padding: 0 1.5rem; user-select: none; }
        .hero-arrow:hover { opacity: 1; }
        
        /* Chatbot Styles */
        #chatbot-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
        #chatbot-button {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
            border: none;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.4);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 24px;
        }
        #chatbot-button:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(13, 110, 253, 0.6);
        }
        #chatbot-window {
            position: absolute;
            bottom: 80px;
            right: 0;
            width: 350px;
            height: 500px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            display: none;
            flex-direction: column;
            overflow: hidden;
        }
        #chatbot-window.active {
            display: flex;
            animation: slideUp 0.3s ease;
        }
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        #chatbot-header {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
            padding: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        #chatbot-header h5 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
        }
        #chatbot-close {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background 0.2s;
        }
        #chatbot-close:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        #chatbot-messages {
            flex: 1;
            padding: 16px;
            overflow-y: auto;
            background: #f8f9fa;
        }
        .chat-message {
            margin-bottom: 12px;
            display: flex;
            align-items: flex-start;
        }
        .chat-message.bot {
            justify-content: flex-start;
        }
        .chat-message.user {
            justify-content: flex-end;
        }
        .message-bubble {
            max-width: 75%;
            padding: 10px 14px;
            border-radius: 18px;
            font-size: 14px;
            line-height: 1.4;
        }
        .chat-message.bot .message-bubble {
            background: white;
            color: #333;
            border-bottom-left-radius: 4px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }
        .chat-message.user .message-bubble {
            background: #0d6efd;
            color: white;
            border-bottom-right-radius: 4px;
        }
        #chatbot-input-container {
            padding: 12px;
            background: white;
            border-top: 1px solid #e9ecef;
            display: flex;
            gap: 8px;
        }
        #chatbot-input {
            flex: 1;
            border: 1px solid #dee2e6;
            border-radius: 20px;
            padding: 8px 16px;
            font-size: 14px;
            outline: none;
        }
        #chatbot-input:focus {
            border-color: #0d6efd;
        }
        #chatbot-send {
            background: #0d6efd;
            color: white;
            border: none;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.2s;
        }
        #chatbot-send:hover {
            background: #0a58ca;
        }
        .quick-replies {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 8px;
        }
        .quick-reply-btn {
            background: white;
            border: 1px solid #0d6efd;
            color: #0d6efd;
            padding: 6px 12px;
            border-radius: 16px;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .quick-reply-btn:hover {
            background: #0d6efd;
            color: white;
        }
        @media (max-width: 768px) {
            #chatbot-window {
                width: calc(100vw - 40px);
                height: 450px;
            }
        }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/navbar.php'; ?>
    <?php require_once __DIR__ . '/sidebar-agence.php'; ?>
    
    <!-- Chatbot -->
    <div id="chatbot-container">
        <button id="chatbot-button" aria-label="Ouvrir le chat">
            <i class="bi bi-chat-dots-fill"></i>
        </button>
        <div id="chatbot-window">
            <div id="chatbot-header">
                <h5><i class="bi bi-robot me-2"></i>Assistant Digita</h5>
                <button id="chatbot-close" aria-label="Fermer le chat">×</button>
            </div>
            <div id="chatbot-messages">
                <div class="chat-message bot">
                    <div class="message-bubble">
                        👋 Bonjour ! Je suis l'assistant virtuel de Digita Marketing. Comment puis-je vous aider aujourd'hui ?
                    </div>
                </div>
                <div class="quick-replies">
                    <button class="quick-reply-btn" data-message="Je veux un devis">💰 Demander un devis</button>
                    <button class="quick-reply-btn" data-message="Vos services">🎯 Vos services</button>
                    <button class="quick-reply-btn" data-message="Vos tarifs">💳 Tarifs</button>
                    <button class="quick-reply-btn" data-message="Vous contacter">📞 Contact</button>
                </div>
            </div>
            <div id="chatbot-input-container">
                <input type="text" id="chatbot-input" placeholder="Écrivez votre message...">
                <button id="chatbot-send" aria-label="Envoyer">
                    <i class="bi bi-send-fill"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 700, once: true });</script>
    
    <!-- Chatbot Script -->
    <script>
        const chatbotButton = document.getElementById('chatbot-button');
        const chatbotWindow = document.getElementById('chatbot-window');
        const chatbotClose = document.getElementById('chatbot-close');
        const chatbotMessages = document.getElementById('chatbot-messages');
        const chatbotInput = document.getElementById('chatbot-input');
        const chatbotSend = document.getElementById('chatbot-send');
        const quickReplyBtns = document.querySelectorAll('.quick-reply-btn');

        // Toggle chatbot
        chatbotButton.addEventListener('click', () => {
            chatbotWindow.classList.toggle('active');
            if (chatbotWindow.classList.contains('active')) {
                chatbotInput.focus();
            }
        });

        chatbotClose.addEventListener('click', () => {
            chatbotWindow.classList.remove('active');
        });

        // Send message
        function sendMessage() {
            const message = chatbotInput.value.trim();
            if (message) {
                addMessage(message, 'user');
                chatbotInput.value = '';
                
                // Simulate bot response
                setTimeout(() => {
                    const response = getBotResponse(message);
                    addMessage(response, 'bot');
                }, 500);
            }
        }

        chatbotSend.addEventListener('click', sendMessage);
        chatbotInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        // Quick replies
        quickReplyBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const message = btn.dataset.message;
                addMessage(message, 'user');
                setTimeout(() => {
                    const response = getBotResponse(message);
                    addMessage(response, 'bot');
                }, 500);
            });
        });

        // Add message to chat
        function addMessage(text, sender) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `chat-message ${sender}`;
            messageDiv.innerHTML = `<div class="message-bubble">${text}</div>`;
            chatbotMessages.appendChild(messageDiv);
            chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
        }

        // Bot responses
        function getBotResponse(message) {
            const lowerMessage = message.toLowerCase();
            
            if (lowerMessage.includes('devis') || lowerMessage.includes('prix') || lowerMessage.includes('tarif')) {
                return '💰 Pour obtenir un devis personnalisé, rendez-vous sur notre <a href="/contact" style="color: #0d6efd;">page contact</a> ou appelez-nous au +262 692 XX XX XX. Nos tarifs commencent à partir de 499€.';
            } else if (lowerMessage.includes('service')) {
                return '🎯 Nous proposons : Création de logos, Production vidéo, Sites web, E-commerce, Tunnels de vente, Management social. Consultez notre <a href="/services" style="color: #0d6efd;">page services</a> pour plus de détails.';
            } else if (lowerMessage.includes('contact') || lowerMessage.includes('appel') || lowerMessage.includes('téléphone')) {
                return '📞 Vous pouvez nous contacter par :<br>• Email : contact@digita-marketing.com<br>• Téléphone : +262 692 XX XX XX<br>• Ou via notre <a href="/contact" style="color: #0d6efd;">formulaire de contact</a>';
            } else if (lowerMessage.includes('horaire') || lowerMessage.includes('ouvert')) {
                return '🕐 Nous sommes disponibles du lundi au vendredi de 9h à 18h, et le samedi de 9h à 13h.';
            } else if (lowerMessage.includes('bonjour') || lowerMessage.includes('salut') || lowerMessage.includes('hello')) {
                return '👋 Bonjour ! Comment puis-je vous aider aujourd\'hui ?';
            } else {
                return '🤔 Je ne suis pas sûr de comprendre. Puis-je vous aider avec un devis, des informations sur nos services, ou nos coordonnées ? N\'hésitez pas à <a href="/contact" style="color: #0d6efd;">nous contacter directement</a> pour plus d\'informations.';
            }
        }
    </script>
