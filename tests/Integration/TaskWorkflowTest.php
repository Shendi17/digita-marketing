<?php

namespace Digita\Marketing\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Digita\Marketing\Services\TaskService;
use Digita\Marketing\Services\ReportingService;

class TaskWorkflowTest extends TestCase
{
    private $taskService;
    private $reportingService;
    private $db;

    protected function setUp(): void
    {
        $this->db = new \PDO(
            'mysql:host=localhost',
            'root',
            ''
        );
        $this->db->exec('DROP DATABASE IF EXISTS digita_marketing_test');
        $this->db->exec('CREATE DATABASE digita_marketing_test');
        $this->db->exec('USE digita_marketing_test');

        $sql = file_get_contents(__DIR__ . '/../../database/setup.sql');
        $this->db->exec($sql);

        $this->taskService = new TaskService($this->db);
        $this->reportingService = new ReportingService($this->db);
    }

    public function testCompleteTaskWorkflow()
    {
        // 1. Créer une tâche marketing
        $taskId = $this->taskService->create([
            'name' => 'Campagne Facebook',
            'type' => 'social_media',
            'due_date' => '2025-02-01',
            'priority' => 'high'
        ]);

        // 2. Assigner la tâche
        $this->taskService->assign($taskId, 1); // ID utilisateur 1

        // 3. Mettre à jour le statut
        $this->taskService->updateStatus($taskId, 'in_progress');

        // 4. Ajouter des métriques
        $this->taskService->addMetrics($taskId, [
            'reach' => 1000,
            'engagement' => 150,
            'clicks' => 75
        ]);

        // 5. Marquer comme terminé
        $this->taskService->complete($taskId);

        // 6. Générer un rapport
        $report = $this->reportingService->generateTaskReport($taskId);

        // Vérifications
        $task = $this->db->query("SELECT * FROM tasks WHERE id = $taskId")->fetch();
        $this->assertEquals('completed', $task['status']);

        $metrics = $this->db->query("SELECT * FROM task_metrics WHERE task_id = $taskId")->fetchAll();
        $this->assertCount(3, $metrics);

        $this->assertNotNull($report);
        $this->assertArrayHasKey('performance_score', $report);
    }

    protected function tearDown(): void
    {
        $this->db->exec('DROP DATABASE IF EXISTS digita_marketing_test');
    }
}
