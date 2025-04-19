<?php

namespace Digita\Marketing\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Digita\Marketing\Maintenance\MaintenanceTools;

class MaintenanceToolsTest extends TestCase
{
    private $maintenance;
    private $db;

    protected function setUp(): void
    {
        // Créer une base de données de test
        $this->db = new \PDO(
            'mysql:host=localhost',
            'root',
            ''
        );
        $this->db->exec('DROP DATABASE IF EXISTS digita_marketing_test');
        $this->db->exec('CREATE DATABASE digita_marketing_test');
        $this->db->exec('USE digita_marketing_test');

        // Importer le schéma de test
        $sql = file_get_contents(__DIR__ . '/../../database/setup.sql');
        $this->db->exec($sql);

        $this->maintenance = new MaintenanceTools();
    }

    public function testCleanupOldTasks()
    {
        // Insérer des tâches de test
        $this->db->exec("
            INSERT INTO background_tasks (name, status, created_at) VALUES
            ('test1', 'completed', DATE_SUB(NOW(), INTERVAL 31 DAY)),
            ('test2', 'completed', DATE_SUB(NOW(), INTERVAL 29 DAY)),
            ('test3', 'failed', DATE_SUB(NOW(), INTERVAL 31 DAY))
        ");

        $this->maintenance->cleanupOldTasks();

        // Vérifier que seules les tâches > 30 jours ont été supprimées
        $result = $this->db->query("SELECT COUNT(*) FROM background_tasks")->fetchColumn();
        $this->assertEquals(1, $result);
    }

    public function testCleanupOldStats()
    {
        // Insérer des statistiques de test
        $this->db->exec("
            INSERT INTO task_statistics (task_type, status, created_at) VALUES
            ('test', 'completed', DATE_SUB(NOW(), INTERVAL 8 DAY)),
            ('test', 'completed', DATE_SUB(NOW(), INTERVAL 6 DAY))
        ");

        $this->maintenance->cleanupOldStats();

        // Vérifier l'agrégation et la suppression
        $oldStats = $this->db->query("
            SELECT COUNT(*) FROM task_statistics 
            WHERE created_at < DATE_SUB(NOW(), INTERVAL 7 DAY)
        ")->fetchColumn();
        
        $this->assertEquals(0, $oldStats);

        $aggregatedStats = $this->db->query("
            SELECT COUNT(*) FROM task_statistics_daily
        ")->fetchColumn();
        
        $this->assertEquals(1, $aggregatedStats);
    }

    public function testCleanupOldReports()
    {
        // Créer des fichiers de test
        $reportDir = __DIR__ . '/../../public/reports';
        if (!is_dir($reportDir)) {
            mkdir($reportDir, 0777, true);
        }

        $oldFile = $reportDir . '/old_report.pdf';
        $newFile = $reportDir . '/new_report.pdf';
        
        file_put_contents($oldFile, 'test');
        file_put_contents($newFile, 'test');

        // Insérer les entrées dans la base de données
        $this->db->exec("
            INSERT INTO generated_reports (file_path, generated_at) VALUES
            ('reports/old_report.pdf', DATE_SUB(NOW(), INTERVAL 31 DAY)),
            ('reports/new_report.pdf', DATE_SUB(NOW(), INTERVAL 29 DAY))
        ");

        $this->maintenance->cleanupOldReports();

        // Vérifier que seul le vieux rapport a été supprimé
        $this->assertFileDoesNotExist($oldFile);
        $this->assertFileExists($newFile);

        // Nettoyer
        unlink($newFile);
        rmdir($reportDir);
    }

    protected function tearDown(): void
    {
        // Supprimer la base de données de test
        $this->db->exec('DROP DATABASE IF EXISTS digita_marketing_test');
    }
}
