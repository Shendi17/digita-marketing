<?php

use PHPUnit\Framework\TestCase;
use Digita\Marketing\Services\NotificationService;

class NotificationServiceTest extends TestCase
{
    private $db;
    private $notificationService;

    protected function setUp(): void
    {
        // Mock de la connexion à la base de données
        $this->db = $this->createMock(PDO::class);
        
        // Créer une instance du service avec le mock
        $this->notificationService = new NotificationService($this->db);
    }

    public function testSendNotification()
    {
        // Préparer le mock pour la requête SQL
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->expects($this->once())
             ->method('execute')
             ->with([
                 'type' => 'test',
                 'message' => 'Test message',
                 'priority' => 'normal'
             ])
             ->willReturn(true);

        $this->db->expects($this->once())
                 ->method('prepare')
                 ->willReturn($stmt);

        // Tester l'envoi d'une notification
        $result = $this->notificationService->sendNotification('test', 'Test message');
        $this->assertTrue($result);
    }

    public function testSendHighPriorityNotification()
    {
        // Préparer le mock pour la requête SQL
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->expects($this->once())
             ->method('execute')
             ->with([
                 'type' => 'urgent',
                 'message' => 'Urgent message',
                 'priority' => 'high'
             ])
             ->willReturn(true);

        $this->db->expects($this->once())
                 ->method('prepare')
                 ->willReturn($stmt);

        // Tester l'envoi d'une notification urgente
        $result = $this->notificationService->sendNotification('urgent', 'Urgent message', 'high');
        $this->assertTrue($result);
    }
}
