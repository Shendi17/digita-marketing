# Script de nettoyage FTP pour résoudre les problèmes de déploiement
# Usage: .\repair-ovh-ftp.ps1

param(
    [switch]$CleanGit = $false,
    [switch]$CleanCache = $false,
    [switch]$FullClean = $false
)

$ErrorActionPreference = "Stop"

function Write-Success { Write-Host $args -ForegroundColor Green }
function Write-Info { Write-Host $args -ForegroundColor Yellow }
function Write-Error { Write-Host $args -ForegroundColor Red }

Write-Success "═══ Script de Nettoyage OVH via FTP ═══"

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

if (-not $FTP_HOST -or -not $FTP_USER -or -not $FTP_PASS) {
    Write-Error "FTP_HOST, FTP_USER et FTP_PASS doivent être configurés dans .env.deploy"
    exit 1
}

Write-Info "`nConfiguration:"
Write-Host "  Serveur: $FTP_HOST"
Write-Host "  Utilisateur: $FTP_USER"
Write-Host "  Chemin: $FTP_PATH"

# Créer un script WinSCP pour le nettoyage
$cleanupScript = @"
option batch abort
option confirm off
open ftp://${FTP_USER}:${FTP_PASS}@${FTP_HOST}
cd ${FTP_PATH}
"@

if ($CleanGit -or $FullClean) {
    Write-Info "`n→ Nettoyage des fichiers Git corrompus..."
    $cleanupScript += @"

# Supprimer le dossier .git corrompu
rm -r .git 2>/dev/null || echo "Pas de .git"
rm .gitignore 2>/dev/null || echo "Pas de .gitignore"
rm .gitattributes 2>/dev/null || echo "Pas de .gitattributes"
"@
}

if ($CleanCache -or $FullClean) {
    Write-Info "`n→ Nettoyage du cache..."
    $cleanupScript += @"

# Vider le cache
rm -r cache/* 2>/dev/null || echo "Cache déjà vide"
"@
}

if ($FullClean) {
    Write-Info "`n→ Nettoyage complet (logs, sessions, etc.)..."
    $cleanupScript += @"

# Nettoyer les logs anciens
rm -r logs/*.log.old 2>/dev/null || echo "Pas de vieux logs"

# Nettoyer les sessions
rm -r sessions/* 2>/dev/null || echo "Pas de sessions"
"@
}

$cleanupScript += @"

# Lister le contenu après nettoyage
ls -la
close
exit
"@

# Afficher le script
Write-Info "`nOpérations qui seront effectuées:"
Write-Host $cleanupScript -ForegroundColor Cyan

$response = Read-Host "`nContinuer ? (o/N)"
if ($response -ne 'o' -and $response -ne 'O') {
    Write-Info "Annulé."
    exit 0
}

# Vérifier si WinSCP est installé
if (-not (Get-Command "winscp.com" -ErrorAction SilentlyContinue)) {
    Write-Error "WinSCP n'est pas installé ou pas dans le PATH"
    Write-Info "`nOptions:"
    Write-Host "1. Installer WinSCP: https://winscp.net/eng/download.php"
    Write-Host "2. Ou utiliser FileZilla pour supprimer manuellement:"
    if ($CleanGit -or $FullClean) {
        Write-Host "   - Supprimer: ${FTP_PATH}.git/"
        Write-Host "   - Supprimer: ${FTP_PATH}.gitignore"
    }
    if ($CleanCache -or $FullClean) {
        Write-Host "   - Vider: ${FTP_PATH}cache/"
    }
    exit 1
}

# Exécuter le nettoyage
try {
    $tempScript = [System.IO.Path]::GetTempFileName() + ".txt"
    $cleanupScript | Out-File -FilePath $tempScript -Encoding ASCII
    
    Write-Info "`n→ Connexion FTP et nettoyage..."
    & winscp.com /script=$tempScript
    
    Remove-Item $tempScript
    
    Write-Success "`n✅ Nettoyage terminé avec succès"
    Write-Info "`nProchaines étapes:"
    Write-Host "1. Relancez le déploiement: git push origin main"
    Write-Host "2. Ou exécutez: .\deploy.ps1"
    Write-Host "3. Vérifiez le site: https://digita.tonyalpha80.com"
    
} catch {
    Write-Error "Erreur lors du nettoyage FTP: $_"
    Write-Info "`nVérifiez:"
    Write-Host "1. Que les credentials FTP sont corrects"
    Write-Host "2. Que le serveur FTP est accessible"
    Write-Host "3. Que vous avez les droits de suppression"
    exit 1
}
