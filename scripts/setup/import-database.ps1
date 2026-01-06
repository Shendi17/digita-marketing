# Script PowerShell pour importer automatiquement toutes les migrations SQL
# Usage: .\scripts\setup\import-database.ps1

Write-Host "`n╔════════════════════════════════════════════════════════════╗" -ForegroundColor Cyan
Write-Host "║   DIGITA MARKETING - Import Base de Données               ║" -ForegroundColor Cyan
Write-Host "╚════════════════════════════════════════════════════════════╝`n" -ForegroundColor Cyan

# Charger .env pour récupérer les credentials
$envFile = ".env"
if (-not (Test-Path $envFile)) {
    Write-Host "❌ Fichier .env introuvable. Copier .env.example vers .env d'abord." -ForegroundColor Red
    exit 1
}

# Parser .env
$envVars = @{}
Get-Content $envFile | ForEach-Object {
    if ($_ -match '^([^#][^=]+)=(.*)$') {
        $key = $matches[1].Trim()
        $value = $matches[2].Trim().Trim('"').Trim("'")
        $envVars[$key] = $value
    }
}

$dbHost = $envVars['DB_HOST']
$dbName = $envVars['DB_NAME']
$dbUser = $envVars['DB_USER']
$dbPass = $envVars['DB_PASS']

Write-Host "📋 Configuration:" -ForegroundColor Yellow
Write-Host "   Host: $dbHost"
Write-Host "   Database: $dbName"
Write-Host "   User: $dbUser`n"

# Détecter MySQL
$mysqlPath = $null
$possiblePaths = @(
    "C:\xampp\mysql\bin\mysql.exe",
    "C:\wamp64\bin\mysql\mysql8.0.31\bin\mysql.exe",
    "C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe",
    "C:\laragon\bin\mysql\mysql-8.0.30\bin\mysql.exe"
)

foreach ($path in $possiblePaths) {
    if (Test-Path $path) {
        $mysqlPath = $path
        break
    }
}

if (-not $mysqlPath) {
    Write-Host "❌ MySQL non trouvé automatiquement." -ForegroundColor Red
    $mysqlPath = Read-Host "Entrez le chemin complet vers mysql.exe"
    if (-not (Test-Path $mysqlPath)) {
        Write-Host "❌ Chemin MySQL invalide. Abandon." -ForegroundColor Red
        exit 1
    }
}

Write-Host "✓ MySQL trouvé: $mysqlPath`n" -ForegroundColor Green

# Créer la base de données
Write-Host "🗄️  Création de la base de données..." -NoNewline
$createDbCmd = "CREATE DATABASE IF NOT EXISTS ``$dbName`` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

if ($dbPass) {
    & $mysqlPath -h $dbHost -u $dbUser -p$dbPass -e $createDbCmd 2>$null
} else {
    & $mysqlPath -h $dbHost -u $dbUser -e $createDbCmd 2>$null
}

if ($LASTEXITCODE -eq 0) {
    Write-Host " ✓" -ForegroundColor Green
} else {
    Write-Host " ✗" -ForegroundColor Red
    Write-Host "❌ Erreur création base de données" -ForegroundColor Red
    exit 1
}

# Liste des fichiers SQL à importer dans l'ordre
$sqlFiles = @(
    "database\digita.sql",
    "database\init.sql",
    "database\create_blog_formations.sql",
    "database\migrations\create_orders_tables.sql",
    "database\migrations\add_missing_indexes.sql"
)

Write-Host "`n📥 Import des tables SQL...`n" -ForegroundColor Cyan

$imported = 0
$failed = 0

foreach ($sqlFile in $sqlFiles) {
    if (Test-Path $sqlFile) {
        Write-Host "Import: $sqlFile..." -NoNewline
        
        if ($dbPass) {
            Get-Content $sqlFile | & $mysqlPath -h $dbHost -u $dbUser -p$dbPass $dbName 2>$null
        } else {
            Get-Content $sqlFile | & $mysqlPath -h $dbHost -u $dbUser $dbName 2>$null
        }
        
        if ($LASTEXITCODE -eq 0) {
            Write-Host " ✓" -ForegroundColor Green
            $imported++
        } else {
            Write-Host " ✗" -ForegroundColor Red
            $failed++
        }
    } else {
        Write-Host "⚠️  Fichier non trouvé: $sqlFile" -ForegroundColor Yellow
    }
}

Write-Host "`n╔════════════════════════════════════════════════════════════╗" -ForegroundColor Green
Write-Host "║   ✅ Import terminé: $imported/$($sqlFiles.Count) fichiers importés           ║" -ForegroundColor Green
Write-Host "╚════════════════════════════════════════════════════════════╝`n" -ForegroundColor Green

if ($failed -gt 0) {
    Write-Host "⚠️  $failed fichier(s) ont échoué" -ForegroundColor Yellow
}

Write-Host "🎯 Prochaines étapes:" -ForegroundColor Cyan
Write-Host "   1. Créer un compte admin sur /inscription"
Write-Host "   2. Exécuter en BDD: UPDATE users SET role = 'admin' WHERE email = 'votre-email@domaine.com';"
Write-Host "   3. Accéder au dashboard: /admin/dashboard`n"

Write-Host "✨ Base de données prête!`n" -ForegroundColor Green
