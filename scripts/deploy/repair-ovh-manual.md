# 🔧 Nettoyage Manuel OVH via FileZilla

**WinSCP n'est pas installé** - Voici comment nettoyer manuellement via FileZilla.

## 📥 Étape 1: Télécharger FileZilla

https://filezilla-project.org/download.php?type=client

## 🔌 Étape 2: Se Connecter à OVH

1. Ouvrir FileZilla
2. Remplir les informations de connexion:
   - **Hôte**: `ftp.cluster127.hosting.ovh.net`
   - **Utilisateur**: `tonyalphzb`
   - **Mot de passe**: `Boosterx80`
   - **Port**: `21`
3. Cliquer sur "Connexion rapide"

## 🧹 Étape 3: Nettoyer les Fichiers Git Corrompus

Une fois connecté, dans le panneau de droite (serveur distant):

1. Naviguer vers `/www/` ou `/` (selon où se trouve votre site)
2. Chercher et **supprimer** ces éléments s'ils existent:
   - Dossier `.git/` (clic droit → Supprimer)
   - Fichier `.gitignore` (clic droit → Supprimer)
   - Fichier `.gitattributes` (clic droit → Supprimer)

## ⚠️ Important

**NE PAS SUPPRIMER**:
- Le dossier `public/`
- Le dossier `app/`
- Le fichier `.env`
- Le dossier `uploads/`
- Tout autre fichier du site

## ✅ Étape 4: Vérification

Après suppression, le dossier distant devrait contenir:
- `app/`
- `public/`
- `includes/`
- `config/`
- `database/`
- `.env`
- Autres fichiers PHP

**Mais PAS de `.git/`**

## 🚀 Étape 5: Relancer le Déploiement

Une fois le nettoyage terminé:

```powershell
# Relancer le workflow GitHub Actions manuellement
# Ou faire un nouveau push
git push origin main
```

Le déploiement devrait maintenant fonctionner correctement !

---

**Alternative**: Si vous préférez installer WinSCP pour l'automatisation:
- Télécharger: https://winscp.net/eng/download.php
- Installer et ajouter au PATH
- Puis exécuter: `.\scripts\deploy\repair-ovh-ftp.ps1 -CleanGit`
