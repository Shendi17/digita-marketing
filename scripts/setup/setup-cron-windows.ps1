# Configuration automatique des tâches planifiées Windows pour DIGITA Marketing
# Exécuter en tant qu'administrateur: .\scripts\setup\setup-cron-windows.ps1

Write-Host "`n╔════════════════════════════════════════════════════════════╗" -ForegroundColor Cyan
Write-Host "║   DIGITA MARKETING - Configuration CRON Windows           ║" -ForegroundColor Cyan
Write-Host "╚════════════════════════════════════════════════════════════╝`n" -ForegroundColor Cyan

# Chemins à configurer
$projectPath = $PSScriptRoot + "\..\..\"
$projectPath = (Resolve-Path $projectPath).Path

# Détecter PHP
$phpPath = $null
$possiblePaths = @(
    "C:\php\php.exe",
    "C:\xampp\php\php.exe",
    "C:\wamp64\bin\php\php8.2.0\php.exe",
    "C:\laragon\bin\php\php-8.2\php.exe"
)

foreach ($path in $possiblePaths) {
    if (Test-Path $path) {
        $phpPath = $path
        break
    }
}

if (-not $phpPath) {
    Write-Host "❌ PHP non trouvé automatiquement." -ForegroundColor Red
    $phpPath = Read-Host "Entrez le chemin complet vers php.exe"
    if (-not (Test-Path $phpPath)) {
        Write-Host "❌ Chemin PHP invalide. Abandon." -ForegroundColor Red
        exit 1
    }
}

Write-Host "✓ PHP trouvé: $phpPath" -ForegroundColor Green
Write-Host "✓ Projet: $projectPath`n" -ForegroundColor Green

# Fonction pour créer une tâche planifiée
function Create-DigiTaskSchedule {
    param(
        [string]$TaskName,
        [string]$ScriptPath,
        [string]$Time,
        [string[]]$DaysOfWeek,
        [string]$Description
    )
    
    Write-Host "Configuration: $TaskName..." -NoNewline
    
    try {
        # Supprimer la tâche si elle existe déjà
        $existingTask = Get-ScheduledTask -TaskName $TaskName -ErrorAction SilentlyContinue
        if ($existingTask) {
            Unregister-ScheduledTask -TaskName $TaskName -Confirm:$false
        }
        
        # Action: Exécuter PHP
        $action = New-ScheduledTaskAction -Execute $phpPath -Argument "`"$ScriptPath`"" -WorkingDirectory $projectPath
        
        # Déclencheur: Horaire spécifique
        $trigger = New-ScheduledTaskTrigger -Weekly -DaysOfWeek $DaysOfWeek -At $Time
        
        # Principal: Utilisateur actuel
        $principal = New-ScheduledTaskPrincipal -UserId "$env:USERDOMAIN\$env:USERNAME" -LogonType S4U -RunLevel Highest
        
        # Paramètres
        $settings = New-ScheduledTaskSettingsSet `
            -AllowStartIfOnBatteries `
            -DontStopIfGoingOnBatteries `
            -StartWhenAvailable `
            -ExecutionTimeLimit (New-TimeSpan -Hours 1)
        
        # Créer la tâche
        Register-ScheduledTask `
            -TaskName $TaskName `
            -Action $action `
            -Trigger $trigger `
            -Principal $principal `
            -Settings $settings `
            -Description $Description `
            -Force | Out-Null
        
        Write-Host " ✓" -ForegroundColor Green
        return $true
    }
    catch {
        Write-Host " ✗" -ForegroundColor Red
        Write-Host "   Erreur: $($_.Exception.Message)" -ForegroundColor Red
        return $false
    }
}

# Créer les tâches
$tasks = @(
    @{
        TaskName = "DIGITA_ClearCache"
        ScriptPath = "$projectPath\scripts\cron\clear-cache.php"
        Time = "02:00"
        DaysOfWeek = @("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday")
        Description = "DIGITA - Nettoyage quotidien du cache et des sessions"
    },
    @{
        TaskName = "DIGITA_BackupDatabase"
        ScriptPath = "$projectPath\scripts\cron\backup-database.php"
        Time = "03:00"
        DaysOfWeek = @("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday")
        Description = "DIGITA - Backup quotidien de la base de données"
    },
    @{
        TaskName = "DIGITA_OptimizeDatabase"
        ScriptPath = "$projectPath\scripts\cron\optimize-database.php"
        Time = "03:00"
        DaysOfWeek = @("Sunday")
        Description = "DIGITA - Optimisation hebdomadaire de la base de données"
    },
    @{
        TaskName = "DIGITA_GenerateSitemap"
        ScriptPath = "$projectPath\scripts\cron\generate-sitemap.php"
        Time = "04:00"
        DaysOfWeek = @("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday")
        Description = "DIGITA - Génération quotidienne du sitemap XML"
    },
    @{
        TaskName = "DIGITA_SendNewsletter"
        ScriptPath = "$projectPath\scripts\cron\send-newsletter.php"
        Time = "10:00"
        DaysOfWeek = @("Monday")
        Description = "DIGITA - Envoi hebdomadaire de la newsletter"
    }
)

$successCount = 0
foreach ($task in $tasks) {
    if (Create-DigiTaskSchedule @task) {
        $successCount++
    }
}

Write-Host "`n╔════════════════════════════════════════════════════════════╗" -ForegroundColor Green
Write-Host "║   ✅ Configuration terminée: $successCount/5 tâches créées          ║" -ForegroundColor Green
Write-Host "╚════════════════════════════════════════════════════════════╝`n" -ForegroundColor Green

Write-Host "📋 Tâches configurées:" -ForegroundColor Cyan
Write-Host "   • DIGITA_ClearCache       - Quotidien 2h" -ForegroundColor White
Write-Host "   • DIGITA_BackupDatabase   - Quotidien 3h" -ForegroundColor White
Write-Host "   • DIGITA_OptimizeDatabase - Dimanche 3h" -ForegroundColor White
Write-Host "   • DIGITA_GenerateSitemap  - Quotidien 4h" -ForegroundColor White
Write-Host "   • DIGITA_SendNewsletter   - Lundi 10h`n" -ForegroundColor White

Write-Host "🔍 Vérifier dans:" -ForegroundColor Yellow
Write-Host "   Panneau de configuration > Outils d'administration > Planificateur de tâches`n" -ForegroundColor White

Write-Host "🧪 Tester manuellement:" -ForegroundColor Yellow
Write-Host "   php scripts\cron\backup-database.php`n" -ForegroundColor White

Write-Host "✨ DIGITA tourne maintenant en autopilot!`n" -ForegroundColor Green
