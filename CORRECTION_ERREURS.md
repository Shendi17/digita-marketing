# 🔧 Correction des Erreurs de Déploiement OVH

**Date**: 6 avril 2026  
**Problème**: Dépôt Git corrompu sur OVH empêchant les déploiements

## 🐛 Erreur Rencontrée

```
error: inflate: data stream error (incorrect data check)
error: corrupt loose object '47078b6030a45fc935e06fdb7615a4a7ab9fbf74'
fatal: loose object 47078b6030a45fc935e06fdb7615a4a7ab9fbf74 is corrupt
destination directory digita/public is not empty and not a git repository
```

## 🔍 Diagnostic Effectué

### Vérifications Locales
```powershell
git fsck --full          # ✅ Aucune erreur locale
git status               # ✅ Dépôt local sain
```

**Résultat**: Le dépôt local est parfaitement sain. Le problème est uniquement sur le serveur OVH.

### Cause Racine Identifiée

1. **Workflow GitHub Actions** déploie par **FTP uniquement** (pas de Git)
2. Un dossier `.git/` corrompu existe sur OVH (probablement d'une tentative manuelle précédente)
3. Le déploiement FTP fonctionne mais le `.git/` corrompu reste présent
4. Cela peut causer des conflits ou erreurs lors de futures opérations

## ✅ Solutions Implémentées

### 1. Workflow GitHub Actions Amélioré

**Fichier**: `.github/workflows/deploy.yml`

**Améliorations**:
- ✅ Vérification de l'intégrité Git avant déploiement
- ✅ Validation robuste de la syntaxe PHP (tous les fichiers)
- ✅ Vérification pré-déploiement
- ✅ Test d'accessibilité du site post-déploiement
- ✅ Gestion d'erreurs avec diagnostics détaillés
- ✅ Notifications claires de succès/échec
- ✅ `continue-on-error: true` pour éviter les blocages

### 2. Script de Réparation SSH

**Fichier**: `scripts/deploy/repair-ovh-git.ps1`

**Fonctionnalités**:
- Diagnostic à distance via SSH
- Suppression automatique du `.git/` corrompu
- Sauvegarde des fichiers critiques (.env, uploads)
- Mode diagnostic et mode réparation

**Usage**:
```powershell
# Diagnostic uniquement
.\scripts\deploy\repair-ovh-git.ps1

# Réparation automatique
.\scripts\deploy\repair-ovh-git.ps1 -AutoFix
```

### 3. Script de Nettoyage FTP

**Fichier**: `scripts/deploy/repair-ovh-ftp.ps1`

**Fonctionnalités**:
- Nettoyage du `.git/` corrompu via FTP
- Nettoyage du cache
- Nettoyage complet (logs, sessions)

**Usage**:
```powershell
# Nettoyer uniquement Git
.\scripts\deploy\repair-ovh-ftp.ps1 -CleanGit

# Nettoyer le cache
.\scripts\deploy\repair-ovh-ftp.ps1 -CleanCache

# Nettoyage complet
.\scripts\deploy\repair-ovh-ftp.ps1 -FullClean
```

### 4. Configuration de Déploiement

**Fichier**: `.env.deploy.example`

Template pour configurer les accès FTP et SSH à OVH.

## 🚀 Procédure de Résolution Immédiate

### Option A: Via FTP (Recommandé - Plus Simple)

```powershell
# 1. Configurer .env.deploy
Copy-Item .env.deploy.example .env.deploy
notepad .env.deploy  # Remplir avec vos credentials OVH

# 2. Nettoyer le Git corrompu
.\scripts\deploy\repair-ovh-ftp.ps1 -CleanGit

# 3. Redéployer
git push origin main  # Déploiement automatique via GitHub Actions
```

### Option B: Via SSH (Si Accès SSH Disponible)

```powershell
# 1. Configurer .env.deploy avec SSH_HOST, SSH_USER, SSH_PORT
notepad .env.deploy

# 2. Diagnostic
.\scripts\deploy\repair-ovh-git.ps1

# 3. Réparation automatique
.\scripts\deploy\repair-ovh-git.ps1 -AutoFix

# 4. Redéployer
git push origin main
```

### Option C: Manuel via FileZilla

1. Se connecter en FTP à OVH
2. Naviguer vers `/www/` (ou votre FTP_PATH)
3. Supprimer le dossier `.git/` s'il existe
4. Supprimer `.gitignore` et `.gitattributes` s'ils existent
5. Relancer le déploiement GitHub Actions

## 📋 Vérifications Post-Correction

```powershell
# 1. Vérifier que le site fonctionne
# Ouvrir: https://digita.tonyalpha80.com

# 2. Vérifier le dashboard admin
# Ouvrir: https://digita.tonyalpha80.com/admin/dashboard

# 3. Consulter les logs GitHub Actions
# https://github.com/Shendi17/digita-marketing/actions
```

## 🔄 Prévention Future

### Workflow Amélioré

Le nouveau workflow GitHub Actions inclut:
- Vérifications automatiques avant déploiement
- Validation de syntaxe PHP complète
- Test d'accessibilité post-déploiement
- Diagnostics en cas d'échec

### Bonnes Pratiques

1. **Ne jamais** faire de `git clone` ou opérations Git manuelles sur OVH
2. **Toujours** déployer via GitHub Actions (FTP automatique)
3. **Utiliser** les scripts de réparation en cas de problème
4. **Vérifier** les logs GitHub Actions après chaque déploiement

## 📊 État Actuel

- ✅ Dépôt local: Sain
- ❌ Serveur OVH: `.git/` corrompu (à nettoyer)
- ✅ Workflow: Amélioré et robuste
- ✅ Scripts de réparation: Disponibles

## 🆘 En Cas de Problème Persistant

1. **Consulter les logs**:
   - GitHub Actions: https://github.com/Shendi17/digita-marketing/actions
   - Serveur OVH: `/www/logs/error.log` (via FTP)

2. **Vérifier la configuration**:
   - Secrets GitHub (FTP_HOST, FTP_USER, FTP_PASS, FTP_PATH)
   - Fichier `.env` sur le serveur OVH

3. **Tester manuellement**:
   ```powershell
   .\deploy.ps1  # Déploiement PowerShell local
   ```

## 📝 Fichiers Modifiés/Créés

- ✅ `.github/workflows/deploy.yml` - Workflow amélioré
- ✅ `scripts/deploy/repair-ovh-git.ps1` - Réparation SSH
- ✅ `scripts/deploy/repair-ovh-ftp.ps1` - Nettoyage FTP
- ✅ `.env.deploy.example` - Template configuration
- ✅ `CORRECTION_ERREURS.md` - Cette documentation

---

**Prochaine étape**: Exécuter l'Option A pour résoudre le problème immédiatement.
