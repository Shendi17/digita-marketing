# Script de Nettoyage du Projet
# Exécuter avec : .\nettoyage-projet.ps1

Write-Host "🧹 NETTOYAGE DU PROJET DIGITA-MARKETING" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

$rootPath = $PSScriptRoot

# 1. Créer la structure docs/
Write-Host "📁 Création de la structure docs/..." -ForegroundColor Yellow

$docsStructure = @(
    "docs",
    "docs\audits",
    "docs\guides",
    "docs\migrations",
    "docs\corrections",
    "docs\archives"
)

foreach ($dir in $docsStructure) {
    $fullPath = Join-Path $rootPath $dir
    if (-not (Test-Path $fullPath)) {
        New-Item -ItemType Directory -Path $fullPath -Force | Out-Null
        Write-Host "  ✓ Créé: $dir" -ForegroundColor Green
    }
}

Write-Host ""

# 2. Déplacer les fichiers d'audit
Write-Host "📊 Déplacement des audits..." -ForegroundColor Yellow

$audits = @(
    "AUDIT_MVC_BLOG.md",
    "AUDIT_MVC_STYLES.md",
    "AUDIT_RESPONSIVE.md",
    "AUDIT_CONFLITS_STYLES.md"
)

foreach ($file in $audits) {
    $source = Join-Path $rootPath $file
    $dest = Join-Path $rootPath "docs\audits\$file"
    if (Test-Path $source) {
        Move-Item -Path $source -Destination $dest -Force
        Write-Host "  ✓ Déplacé: $file" -ForegroundColor Green
    }
}

Write-Host ""

# 3. Déplacer les guides
Write-Host "📚 Déplacement des guides..." -ForegroundColor Yellow

$guides = @(
    "QUICK_START.md",
    "FEATURES.md",
    "GUIDE_EXECUTION.md",
    "INDEX_DOCUMENTATION.md",
    "OPTIMISATION_COMPLETE.md",
    "OPTIMISATION_100_POURCENT.md",
    "PLAN_NETTOYAGE.md"
)

foreach ($file in $guides) {
    $source = Join-Path $rootPath $file
    $dest = Join-Path $rootPath "docs\guides\$file"
    if (Test-Path $source) {
        Move-Item -Path $source -Destination $dest -Force
        Write-Host "  ✓ Déplacé: $file" -ForegroundColor Green
    }
}

Write-Host ""

# 4. Déplacer les migrations
Write-Host "🔄 Déplacement des migrations..." -ForegroundColor Yellow

$migrations = Get-ChildItem -Path $rootPath -Filter "MIGRATION_*.md"
$migrations += Get-ChildItem -Path $rootPath -Filter "STRUCTURE_MVC_*.md"
$migrations += Get-ChildItem -Path $rootPath -Filter "*MIGRATION*.md"

foreach ($file in $migrations) {
    $dest = Join-Path $rootPath "docs\migrations\$($file.Name)"
    Move-Item -Path $file.FullName -Destination $dest -Force
    Write-Host "  ✓ Déplacé: $($file.Name)" -ForegroundColor Green
}

Write-Host ""

# 5. Déplacer les corrections
Write-Host "🔧 Déplacement des corrections..." -ForegroundColor Yellow

$corrections = Get-ChildItem -Path $rootPath -Filter "CORRECTION_*.md"
$corrections += Get-ChildItem -Path $rootPath -Filter "RESOLUTION_*.md"
$corrections += Get-ChildItem -Path $rootPath -Filter "SOLUTION_*.md"
$corrections += Get-ChildItem -Path $rootPath -Filter "NETTOYAGE_*.md"

foreach ($file in $corrections) {
    $dest = Join-Path $rootPath "docs\corrections\$($file.Name)"
    Move-Item -Path $file.FullName -Destination $dest -Force
    Write-Host "  ✓ Déplacé: $($file.Name)" -ForegroundColor Green
}

Write-Host ""

# 6. Déplacer les autres MD vers archives
Write-Host "📦 Déplacement vers archives..." -ForegroundColor Yellow

$archives = Get-ChildItem -Path $rootPath -Filter "*.md" | Where-Object {
    $_.Name -ne "README.md" -and 
    $_.Name -ne "CHANGELOG.md" -and
    $_.Name -ne "PLAN_NETTOYAGE.md"
}

foreach ($file in $archives) {
    $dest = Join-Path $rootPath "docs\archives\$($file.Name)"
    Move-Item -Path $file.FullName -Destination $dest -Force
    Write-Host "  ✓ Archivé: $($file.Name)" -ForegroundColor Green
}

Write-Host ""

# 7. Supprimer scripts temporaires dans public/
Write-Host "🗑️  Suppression des scripts temporaires..." -ForegroundColor Yellow

$tempScripts = @(
    "public\migrate-article-slug.php",
    "public\link-all-formations.php",
    "public\create-missing-articles.php",
    "public\create-last-2-articles.php"
)

foreach ($script in $tempScripts) {
    $fullPath = Join-Path $rootPath $script
    if (Test-Path $fullPath) {
        Remove-Item -Path $fullPath -Force
        Write-Host "  ✓ Supprimé: $script" -ForegroundColor Green
    }
}

Write-Host ""

# 8. Supprimer fichiers obsolètes
Write-Host "🗑️  Suppression des fichiers obsolètes..." -ForegroundColor Yellow

$obsoletes = @(
    "Amélios",
    "SUCCESS.txt",
    "INSTALLATION_COMPLETE.txt",
    "VERSION_2.1_COMPLETE.txt",
    "PROJECT_STRUCTURE.txt",
    "create-catalogue-view.ps1",
    "create-views.ps1",
    "setup_git.bat"
)

foreach ($file in $obsoletes) {
    $fullPath = Join-Path $rootPath $file
    if (Test-Path $fullPath) {
        Remove-Item -Path $fullPath -Force
        Write-Host "  ✓ Supprimé: $file" -ForegroundColor Green
    }
}

Write-Host ""

# 9. Créer INDEX.md dans docs/
Write-Host "📝 Création de l'index de documentation..." -ForegroundColor Yellow

$indexContent = @"
# 📚 Documentation Digita Marketing

## 🎯 Guides Principaux

- [Quick Start](guides/QUICK_START.md) - Démarrage rapide
- [Features](guides/FEATURES.md) - Fonctionnalités
- [Guide d'Exécution](guides/GUIDE_EXECUTION.md)
- [Optimisation Complète](guides/OPTIMISATION_COMPLETE.md)

## 📊 Audits

- [Audit MVC](audits/AUDIT_MVC_STYLES.md)
- [Audit Responsive](audits/AUDIT_RESPONSIVE.md)
- [Audit Conflits CSS](audits/AUDIT_CONFLITS_STYLES.md)

## 🔄 Migrations

Voir le dossier [migrations/](migrations/) pour l'historique complet des migrations MVC.

## 🔧 Corrections

Voir le dossier [corrections/](corrections/) pour l'historique des corrections.

## 📦 Archives

Voir le dossier [archives/](archives/) pour les anciennes documentations.

---

**Dernière mise à jour** : $(Get-Date -Format "dd/MM/yyyy")
"@

$indexPath = Join-Path $rootPath "docs\INDEX.md"
Set-Content -Path $indexPath -Value $indexContent -Encoding UTF8
Write-Host "  ✓ Créé: docs\INDEX.md" -ForegroundColor Green

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "✅ NETTOYAGE TERMINÉ !" -ForegroundColor Green
Write-Host ""
Write-Host "📁 Structure créée:" -ForegroundColor Cyan
Write-Host "  - docs/audits/" -ForegroundColor White
Write-Host "  - docs/guides/" -ForegroundColor White
Write-Host "  - docs/migrations/" -ForegroundColor White
Write-Host "  - docs/corrections/" -ForegroundColor White
Write-Host "  - docs/archives/" -ForegroundColor White
Write-Host ""
Write-Host "🗑️  Fichiers supprimés:" -ForegroundColor Cyan
Write-Host "  - Scripts temporaires (public/)" -ForegroundColor White
Write-Host "  - Fichiers obsolètes (.txt, .ps1, .bat)" -ForegroundColor White
Write-Host ""
Write-Host "📝 Fichiers à la racine:" -ForegroundColor Cyan
Write-Host "  - README.md" -ForegroundColor White
Write-Host "  - CHANGELOG.md" -ForegroundColor White
Write-Host "  - .env, .gitignore, composer.json" -ForegroundColor White
Write-Host ""
Write-Host "🎉 Projet nettoyé et organisé !" -ForegroundColor Green
