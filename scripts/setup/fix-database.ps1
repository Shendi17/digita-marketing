# Script PowerShell pour corriger et réimporter la base de données
# Usage: .\scripts\setup\fix-database.ps1

Write-Host "`n╔════════════════════════════════════════════════════════════╗" -ForegroundColor Cyan
Write-Host "║   DIGITA MARKETING - Correction Base de Données           ║" -ForegroundColor Cyan
Write-Host "╚════════════════════════════════════════════════════════════╝`n" -ForegroundColor Cyan

# Charger .env
$envFile = ".env"
if (-not (Test-Path $envFile)) {
    Write-Host "❌ Fichier .env introuvable." -ForegroundColor Red
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
    Write-Host "❌ MySQL non trouvé." -ForegroundColor Red
    exit 1
}

Write-Host "✓ MySQL trouvé: $mysqlPath`n" -ForegroundColor Green

# Fonction pour exécuter SQL
function Execute-SQL {
    param($SqlContent)
    
    $tempFile = [System.IO.Path]::GetTempFileName() + ".sql"
    $SqlContent | Out-File -FilePath $tempFile -Encoding UTF8
    
    if ($dbPass) {
        Get-Content $tempFile | & $mysqlPath -h $dbHost -u $dbUser -p$dbPass $dbName 2>&1 | Out-Null
    } else {
        Get-Content $tempFile | & $mysqlPath -h $dbHost -u $dbUser $dbName 2>&1 | Out-Null
    }
    
    Remove-Item $tempFile -Force
    return $LASTEXITCODE -eq 0
}

Write-Host "🔧 Correction des problèmes...`n" -ForegroundColor Cyan

# 1. Créer table newsletter_subscribers si manquante
Write-Host "1. Vérification table newsletter_subscribers..." -NoNewline
$sqlNewsletterTable = @"
CREATE TABLE IF NOT EXISTS newsletter_subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
"@

if (Execute-SQL $sqlNewsletterTable) {
    Write-Host " ✓" -ForegroundColor Green
} else {
    Write-Host " ✗" -ForegroundColor Red
}

# 2. Réimporter create_blog_formations.sql
Write-Host "2. Réimport create_blog_formations.sql..." -NoNewline
if (Test-Path "database\create_blog_formations.sql") {
    if ($dbPass) {
        Get-Content "database\create_blog_formations.sql" | & $mysqlPath -h $dbHost -u $dbUser -p$dbPass $dbName 2>$null
    } else {
        Get-Content "database\create_blog_formations.sql" | & $mysqlPath -h $dbHost -u $dbUser $dbName 2>$null
    }
    
    if ($LASTEXITCODE -eq 0) {
        Write-Host " ✓" -ForegroundColor Green
    } else {
        Write-Host " ✗" -ForegroundColor Red
    }
} else {
    Write-Host " ⚠️  Fichier non trouvé" -ForegroundColor Yellow
}

# 3. Réimporter add_missing_indexes.sql
Write-Host "3. Réimport add_missing_indexes.sql..." -NoNewline
if (Test-Path "database\migrations\add_missing_indexes.sql") {
    if ($dbPass) {
        Get-Content "database\migrations\add_missing_indexes.sql" | & $mysqlPath -h $dbHost -u $dbUser -p$dbPass $dbName 2>$null
    } else {
        Get-Content "database\migrations\add_missing_indexes.sql" | & $mysqlPath -h $dbHost -u $dbUser $dbName 2>$null
    }
    
    if ($LASTEXITCODE -eq 0) {
        Write-Host " ✓" -ForegroundColor Green
    } else {
        Write-Host " ⚠️  Certains index existent déjà (normal)" -ForegroundColor Yellow
    }
} else {
    Write-Host " ⚠️  Fichier non trouvé" -ForegroundColor Yellow
}

Write-Host "`n╔════════════════════════════════════════════════════════════╗" -ForegroundColor Green
Write-Host "║   ✅ Corrections appliquées                                ║" -ForegroundColor Green
Write-Host "╚════════════════════════════════════════════════════════════╝`n" -ForegroundColor Green

Write-Host "🧪 Retester le système:" -ForegroundColor Yellow
Write-Host "   php scripts\setup\test-system.php`n" -ForegroundColor White

Write-Host "✨ Base de données corrigée!`n" -ForegroundColor Green
