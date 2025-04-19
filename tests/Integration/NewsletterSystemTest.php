<?php

namespace Digita\Marketing\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Digita\Marketing\Services\NewsletterService;
use Digita\Marketing\Services\StatisticsService;
use Digita\Marketing\Services\NotificationService;

class NewsletterSystemTest extends TestCase
{
    private $newsletterService;
    private $statisticsService;
    private $notificationService;
    private $db;

    protected function setUp(): void
    {
        // Configuration de la base de données de test
        $this->db = new \PDO(
            'mysql:host=localhost',
            'root',
            ''
        );
        $this->db->exec('DROP DATABASE IF EXISTS digita_marketing_test');
        $this->db->exec('CREATE DATABASE digita_marketing_test');
        $this->db->exec('USE digita_marketing_test');

        // Import du schéma
        $sql = file_get_contents(__DIR__ . '/../../database/setup.sql');
        $this->db->exec($sql);

        // Initialisation des services
        $this->newsletterService = new NewsletterService($this->db);
        $this->statisticsService = new StatisticsService($this->db);
        $this->notificationService = new NotificationService($this->db);
    }

    public function testCompleteNewsletterWorkflow()
    {
        // 1. Créer une newsletter
        $newsletterId = $this->newsletterService->create([
            'title' => 'Newsletter Test',
            'content' => 'Contenu de test',
            'schedule' => '2025-02-01 10:00:00'
        ]);
        
        $this->assertNotNull($newsletterId);

        // 2. Vérifier la création dans la base de données
        $newsletter = $this->db->query("SELECT * FROM newsletters WHERE id = $newsletterId")->fetch();
        $this->assertEquals('Newsletter Test', $newsletter['title']);

        // 3. Simuler l'envoi
        $result = $this->newsletterService->send($newsletterId);
        $this->assertTrue($result);

        // 4. Vérifier les statistiques
        $stats = $this->statisticsService->getNewsletterStats($newsletterId);
        $this->assertArrayHasKey('sent_count', $stats);
        $this->assertArrayHasKey('open_rate', $stats);

        // 5. Vérifier les notifications
        $notifications = $this->notificationService->getNotifications('newsletter');
        $this->assertNotEmpty($notifications);
    }

    public function testNewsletterFailureHandling()
    {
        // 1. Créer une newsletter avec des données invalides
        $newsletterId = $this->newsletterService->create([
            'title' => 'Newsletter Erreur',
            'content' => '', // Contenu vide pour provoquer une erreur
            'schedule' => '2025-02-01 10:00:00'
        ]);

        // 2. Tenter l'envoi
        $result = $this->newsletterService->send($newsletterId);
        $this->assertFalse($result);

        // 3. Vérifier les logs d'erreur
        $errors = $this->db->query("SELECT * FROM error_logs WHERE entity_type = 'newsletter' AND entity_id = $newsletterId")->fetchAll();
        $this->assertNotEmpty($errors);

        // 4. Vérifier les notifications d'erreur
        $notifications = $this->notificationService->getNotifications('error');
        $this->assertNotEmpty($notifications);
    }

    protected function tearDown(): void
    {
        // Nettoyage
        $this->db->exec('DROP DATABASE IF EXISTS digita_marketing_test');
    }
}
