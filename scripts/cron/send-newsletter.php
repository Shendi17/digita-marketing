<?php
/**
 * Script d'envoi automatique de newsletter
 * À exécuter hebdomadairement via CRON: 0 10 * * 1 (Lundi 10h)
 */

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../app/Models/Newsletter.php';
require_once __DIR__ . '/../../app/Services/EmailService.php';

$newsletterModel = new Newsletter();
$emailService = new EmailService();

// Récupérer tous les abonnés actifs
$subscribers = $newsletterModel->getActiveSubscribers();

if (empty($subscribers)) {
    echo "Aucun abonné actif\n";
    exit;
}

echo "Envoi de la newsletter à " . count($subscribers) . " abonnés...\n";

// Récupérer le contenu de la newsletter (derniers articles, formations, etc.)
require_once __DIR__ . '/../../app/Models/Article.php';
require_once __DIR__ . '/../../app/Models/Formation.php';

$articleModel = new Article();
$formationModel = new Formation();

$latestArticles = $articleModel->getAllPublished(5);
$latestFormations = $formationModel->getAllPublished(3);

// Générer le contenu HTML de la newsletter
$content = generateNewsletterContent($latestArticles, $latestFormations);

$sent = 0;
$failed = 0;

foreach ($subscribers as $subscriber) {
    try {
        $emailService->send(
            $subscriber['email'],
            'Newsletter Digita Marketing - ' . date('F Y'),
            $content
        );
        $sent++;
        
        // Pause pour éviter d'être bloqué par le serveur SMTP
        usleep(100000); // 0.1 seconde
        
    } catch (Exception $e) {
        $failed++;
        error_log("Erreur envoi newsletter à {$subscriber['email']}: " . $e->getMessage());
    }
}

echo "✓ Newsletter envoyée: {$sent} réussies, {$failed} échecs\n";

function generateNewsletterContent($articles, $formations) {
    ob_start();
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: #2563eb; color: white; padding: 20px; text-align: center; }
            .content { padding: 20px; background: #f9fafb; }
            .article { margin-bottom: 20px; padding: 15px; background: white; border-radius: 8px; }
            .footer { text-align: center; padding: 20px; font-size: 12px; color: #6b7280; }
            a { color: #2563eb; text-decoration: none; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>Newsletter Digita Marketing</h1>
                <p><?= date('F Y') ?></p>
            </div>
            
            <div class="content">
                <h2>📚 Derniers Articles</h2>
                <?php foreach ($articles as $article): ?>
                <div class="article">
                    <h3><?= htmlspecialchars($article['title']) ?></h3>
                    <p><?= htmlspecialchars(substr($article['excerpt'], 0, 150)) ?>...</p>
                    <a href="<?= APP_URL ?>/blog/<?= $article['slug'] ?>">Lire la suite →</a>
                </div>
                <?php endforeach; ?>
                
                <h2>🎓 Nouvelles Formations</h2>
                <?php foreach ($formations as $formation): ?>
                <div class="article">
                    <h3><?= htmlspecialchars($formation['title']) ?></h3>
                    <p><?= htmlspecialchars(substr($formation['description'], 0, 150)) ?>...</p>
                    <a href="<?= APP_URL ?>/formations/<?= $formation['slug'] ?>">Découvrir →</a>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="footer">
                <p>Vous recevez cet email car vous êtes abonné à notre newsletter.</p>
                <p><a href="<?= APP_URL ?>/newsletter/unsubscribe">Se désabonner</a></p>
            </div>
        </div>
    </body>
    </html>
    <?php
    return ob_get_clean();
}
