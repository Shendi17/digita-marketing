# 🚀 Guide de Déploiement - Digita Marketing

## 📋 Résumé Rapide

**Problème actuel**: Dépôt Git corrompu sur OVH  
**Solution**: Scripts de réparation automatique créés  
**Déploiement**: Via GitHub Actions (FTP automatique)

## ⚡ Résolution Rapide du Problème Actuel

### Étape 1: Configuration

```powershell
# Copier et configurer .env.deploy
Copy-Item .env.deploy.example .env.deploy
notepad .env.deploy
```

Remplir avec vos credentials OVH:
```
FTP_HOST=ftp.cluster0XX.hosting.ovh.net
FTP_USER=votre_user_ftp
FTP_PASS=votre_password_ftp
FTP_PATH=/www/
```

### Étape 2: Nettoyage du Serveur

```powershell
# Nettoyer le Git corrompu sur OVH
.\scripts\deploy\repair-ovh-ftp.ps1 -CleanGit
```

### Étape 3: Redéploiement

```powershell
# Commiter les nouvelles modifications
git add .
git commit -m "Fix: Amélioration workflow et scripts de réparation"
git push origin main

# Le déploiement se lance automatiquement via GitHub Actions
```

### Étape 4: Vérification

- ✅ Consulter: https://github.com/Shendi17/digita-marketing/actions
- ✅ Tester: https://digita.tonyalpha80.com
- ✅ Admin: https://digita.tonyalpha80.com/admin/dashboard

## 📁 Fichiers Créés/Modifiés

### Nouveaux Fichiers

1. **`.github/workflows/deploy.yml`** - Workflow GitHub Actions amélioré
   - Vérification intégrité Git
   - Validation PHP robuste
   - Test d'accessibilité post-déploiement
   - Diagnostics détaillés

2. **`scripts/deploy/repair-ovh-git.ps1`** - Réparation via SSH
   - Diagnostic à distance
   - Suppression automatique du `.git/` corrompu
   - Sauvegarde des fichiers critiques

3. **`scripts/deploy/repair-ovh-ftp.ps1`** - Nettoyage via FTP
   - Nettoyage Git corrompu
   - Nettoyage cache
   - Nettoyage complet

4. **`.env.deploy.example`** - Template de configuration
   - Credentials FTP
   - Credentials SSH (optionnel)

5. **`CORRECTION_ERREURS.md`** - Documentation détaillée du problème

### Fichiers Existants (Inchangés)

- `deploy.ps1` - Script de déploiement PowerShell manuel
- `deploy.sh` - Script de déploiement Bash manuel
- `.github/workflows/ci.yml` - Tests CI
- `.github/workflows/blank.yml` - Workflow vide

## 🔧 Scripts Disponibles

### 1. Réparation FTP (Recommandé)

```powershell
# Nettoyer uniquement Git
.\scripts\deploy\repair-ovh-ftp.ps1 -CleanGit

# Nettoyer le cache
.\scripts\deploy\repair-ovh-ftp.ps1 -CleanCache

# Nettoyage complet
.\scripts\deploy\repair-ovh-ftp.ps1 -FullClean
```

**Prérequis**: WinSCP installé (https://winscp.net)

### 2. Réparation SSH (Avancé)

```powershell
# Diagnostic uniquement
.\scripts\deploy\repair-ovh-git.ps1

# Réparation automatique
.\scripts\deploy\repair-ovh-git.ps1 -AutoFix
```

**Prérequis**: Accès SSH à OVH configuré

### 3. Déploiement Manuel

```powershell
# Via PowerShell
.\deploy.ps1

# Avec environnement spécifique
.\deploy.ps1 -Environment production
```

## 🌐 Workflow de Déploiement Automatique

### Déclenchement

Le déploiement se lance automatiquement à chaque:
- Push sur la branche `main`
- Déclenchement manuel via GitHub Actions

### Étapes du Workflow

1. ✅ Checkout du code
2. ✅ Configuration PHP 8.2
3. ✅ Vérification intégrité Git
4. ✅ Validation syntaxe PHP (tous les fichiers)
5. ✅ Vérification pré-déploiement
6. ✅ Déploiement FTP
7. ✅ Test d'accessibilité du site
8. ✅ Notification de succès/échec

### Fichiers Exclus du Déploiement

- `.git/` et `.git*/**`
- `node_modules/`
- `vendor/`
- `.env` (doit être configuré manuellement sur le serveur)
- `logs/`, `cache/`, `backups/`
- `tests/`
- Scripts de déploiement (`.sh`, `.ps1`)
- Documentation (`DEPLOIEMENT.md`, `CORRECTION_ERREURS.md`)

## 🔍 Diagnostic

### Vérifier l'État Local

```powershell
# Intégrité Git
git fsck --full

# Statut
git status

# Derniers commits
git log --oneline -10
```

### Vérifier GitHub Actions

1. Aller sur: https://github.com/Shendi17/digita-marketing/actions
2. Consulter le dernier workflow "Deploy to OVH"
3. Vérifier les logs de chaque étape

### Vérifier le Site en Production

```powershell
# Test HTTP
curl -I https://digita.tonyalpha80.com

# Ou ouvrir dans le navigateur
start https://digita.tonyalpha80.com
```

## 📊 Configuration GitHub Secrets

Pour que le déploiement automatique fonctionne, configurez ces secrets:

1. Aller sur: https://github.com/Shendi17/digita-marketing/settings/secrets/actions
2. Ajouter:
   - `FTP_HOST` - Serveur FTP OVH
   - `FTP_USER` - Utilisateur FTP
   - `FTP_PASS` - Mot de passe FTP
   - `FTP_PATH` - Chemin (généralement `/www/`)

## 🆘 Problèmes Courants

### Déploiement GitHub Actions Échoue

**Vérifier**:
1. Secrets GitHub correctement configurés
2. Credentials FTP valides
3. Serveur FTP accessible
4. Logs GitHub Actions pour détails

**Solution**: Consulter `CORRECTION_ERREURS.md`

### Site Inaccessible Après Déploiement

**Vérifier**:
1. Fichier `.env` sur le serveur OVH
2. Permissions des fichiers (755 pour dossiers, 644 pour fichiers)
3. Logs d'erreurs: `/www/logs/error.log`

### Modifications Non Appliquées

**Causes**:
1. Cache navigateur → Ctrl+Shift+R
2. Cache serveur → Nettoyer via FTP: `/www/cache/*`
3. Déploiement incomplet → Vérifier GitHub Actions

## 📝 Checklist Avant Déploiement

- [ ] Tests locaux réussis
- [ ] Pas d'erreurs de syntaxe PHP
- [ ] Modifications commitées
- [ ] `.env` production configuré sur OVH
- [ ] Secrets GitHub à jour
- [ ] Backup BDD récent (si modifications BDD)

## 🔄 Rollback (Retour en Arrière)

```powershell
# Trouver le commit précédent
git log --oneline

# Revenir en arrière
git revert <hash_commit>
git push origin main  # Redéploiement automatique
```

---

**Documentation complète**: Voir `CORRECTION_ERREURS.md`  
**Dernière mise à jour**: 6 avril 2026
