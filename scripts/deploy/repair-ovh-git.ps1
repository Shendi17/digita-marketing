# Script de réparation automatique du dépôt Git corrompu sur OVH
# Usage: .\repair-ovh-git.ps1

param(
    [switch]$AutoFix = $false
)

$ErrorActionPreference = "Stop"

function Write-Success { Write-Host $args -ForegroundColor Green }
function Write-Info { Write-Host $args -ForegroundColor Yellow }
function Write-Error { Write-Host $args -ForegroundColor Red }

Write-Success "=== Script de Réparation Git OVH ==="

# Charger la configuration
if (-not (Test-Path ".env.deploy")) {
    Write-Error "Fichier .env.deploy manquant. Créez-le depuis .env.deploy.example"
    exit 1
}

Get-Content ".env.deploy" | ForEach-Object {
    if ($_ -match "^([^=]+)=(.+)$") {
        Set-Variable -Name $matches[1] -Value $matches[2] -Scope Script
    }
}

Write-Info "`n→ Vérification de la connexion SSH..."

# Vérifier si SSH est disponible
if (-not $SSH_HOST -or -not $SSH_USER) {
    Write-Error "SSH_HOST et SSH_USER doivent être configurés dans .env.deploy"
    exit 1
}

# Commandes de diagnostic
$diagCommands = @"
cd ~/digita/public
echo "=== Vérification du dossier ==="
pwd
ls -la | head -20

echo "`n=== Test Git ==="
if [ -d .git ]; then
    echo "Dossier .git existe"
    git status 2>&1 | head -10
    git fsck 2>&1 | head -10
else
    echo "Pas de dossier .git"
fi

echo "`n=== Espace disque ==="
du -sh .
df -h . | tail -1
"@

Write-Info "→ Exécution du diagnostic sur OVH..."
Write-Host "`nCommandes qui seront exécutées:"
Write-Host $diagCommands -ForegroundColor Cyan

if (-not $AutoFix) {
    Write-Info "`nMode diagnostic uniquement. Utilisez -AutoFix pour réparer automatiquement."
    $response = Read-Host "`nExécuter le diagnostic ? (o/N)"
    if ($response -ne 'o' -and $response -ne 'O') {
        Write-Info "Annulé."
        exit 0
    }
}

# Créer un fichier temporaire avec les commandes
$tempScript = [System.IO.Path]::GetTempFileName() + ".sh"
$diagCommands | Out-File -FilePath $tempScript -Encoding ASCII

try {
    # Exécuter via SSH
    Write-Info "`n→ Connexion SSH à $SSH_HOST..."
    
    # Utiliser ssh avec le script
    $sshCommand = "ssh -p $SSH_PORT ${SSH_USER}@${SSH_HOST} 'bash -s' < `"$tempScript`""
    
    Write-Host "`nRésultats du diagnostic:" -ForegroundColor Cyan
    Invoke-Expression $sshCommand
    
    Write-Success "`n✓ Diagnostic terminé"
    
    if ($AutoFix) {
        Write-Info "`n→ Application de la réparation automatique..."
        
        $fixCommands = @"
cd ~/digita/public

# Sauvegarder les fichiers importants
echo "Sauvegarde de .env et uploads..."
cp .env ~/.env.backup.digita 2>/dev/null || true
tar -czf ~/digita_uploads_backup.tar.gz public/uploads/ 2>/dev/null || true

# Supprimer le dossier .git corrompu
echo "Suppression du .git corrompu..."
rm -rf .git

# Nettoyer les fichiers Git résiduels
rm -f .gitignore .gitattributes

echo "✓ Réparation terminée"
echo "Le prochain déploiement FTP fonctionnera correctement"
"@
        
        $tempFixScript = [System.IO.Path]::GetTempFileName() + ".sh"
        $fixCommands | Out-File -FilePath $tempFixScript -Encoding ASCII
        
        $sshFixCommand = "ssh -p $SSH_PORT ${SSH_USER}@${SSH_HOST} 'bash -s' < `"$tempFixScript`""
        Invoke-Expression $sshFixCommand
        
        Remove-Item $tempFixScript
        
        Write-Success "`n✓ Réparation appliquée avec succès"
        Write-Info "`nProchaines étapes:"
        Write-Host "1. Relancez le déploiement GitHub Actions"
        Write-Host "2. Ou exécutez: .\deploy.ps1"
    } else {
        Write-Info "`nPour réparer automatiquement, exécutez:"
        Write-Host ".\scripts\deploy\repair-ovh-git.ps1 -AutoFix" -ForegroundColor Cyan
    }
    
} catch {
    Write-Error "Erreur lors de la connexion SSH: $_"
    Write-Info "`nVérifiez:"
    Write-Host "1. Que vous avez accès SSH à OVH"
    Write-Host "2. Que SSH_HOST, SSH_USER, SSH_PORT sont corrects dans .env.deploy"
    Write-Host "3. Que votre clé SSH est configurée (ou utilisez mot de passe)"
    exit 1
} finally {
    Remove-Item $tempScript -ErrorAction SilentlyContinue
}
