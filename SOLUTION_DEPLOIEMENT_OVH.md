# 🚨 Solution au Problème de Déploiement OVH

## Problème Actuel

OVH utilise un **déploiement Git automatique** qui est en conflit avec les fichiers existants.

```
error: Your local changes to the following files would be overwritten by merge
error: The following untracked working tree files would be overwritten by merge
```

## ✅ Solution Recommandée: Nettoyage Complet

### Étape 1: Désactiver le Déploiement Git OVH

1. Connectez-vous à votre **espace client OVH**
2. Allez dans **Hébergements** → Votre hébergement
3. Onglet **Déploiement Git**
4. **Supprimez** ou **Désactivez** le déploiement Git configuré

### Étape 2: Nettoyer le Serveur via FTP

**Avec FileZilla:**

1. Connectez-vous:
   - Hôte: `ftp.cluster127.hosting.ovh.net`
   - User: `tonyalphzb`
   - Pass: `Boosterx80`

2. Naviguez vers `/home/tonyalphzb/digita/`

3. **Supprimez TOUT** dans ce dossier (sauf si vous avez des données importantes)
   - Sélectionnez tous les fichiers/dossiers
   - Clic droit → Supprimer

4. Le dossier `/home/tonyalphzb/digita/` doit être **complètement vide**

### Étape 3: Configurer le Déploiement FTP GitHub Actions

1. Allez sur: https://github.com/Shendi17/digita-marketing/settings/secrets/actions

2. Vérifiez/Ajoutez ces secrets:

| Nom | Valeur |
|-----|--------|
| `FTP_HOST` | `ftp.cluster127.hosting.ovh.net` |
| `FTP_USER` | `tonyalphzb` |
| `FTP_PASS` | `Boosterx80` |
| `FTP_PATH` | `/home/tonyalphzb/digita/` |

### Étape 4: Déclencher le Déploiement

1. Allez sur: https://github.com/Shendi17/digita-marketing/actions
2. Cliquez sur **"Deploy to OVH"** dans la liste à gauche
3. Cliquez sur **"Run workflow"** → **"Run workflow"**

Le workflow va déployer tous les fichiers par FTP (pas Git).

### Étape 5: Créer le fichier .env

Via FileZilla, créez `/home/tonyalphzb/digita/.env`:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://digita.tonyalpha80.com

DB_HOST=tonyalphzbdigita.mysql.db
DB_NAME=tonyalphzbdigita
DB_USER=tonyalphzbdigita
DB_PASS=VOTRE_MOT_DE_PASSE_BDD

SESSION_SECURE=true
SESSION_HTTPONLY=true

STRIPE_PUBLIC_KEY=pk_test_VOTRE_CLE
STRIPE_SECRET_KEY=sk_test_VOTRE_CLE
OPENAI_API_KEY=sk-VOTRE_CLE
```

### Étape 6: Exécuter le Setup

Accédez à: **https://digita.tonyalpha80.com/setup.php**

Cela créera les dossiers `logs/`, `cache/`, etc.

### Étape 7: Tester

- Page d'accueil: https://digita.tonyalpha80.com
- Admin: https://digita.tonyalpha80.com/admin/dashboard

### Étape 8: Sécurité

Supprimez via FTP:
- `/home/tonyalphzb/digita/public/setup.php`
- `/home/tonyalphzb/digita/public/diagnostic.php`

---

## 🔄 Option Alternative: Forcer le Déploiement Git OVH

Si vous voulez continuer avec Git OVH (non recommandé):

1. Dans l'espace client OVH, section **Déploiement Git**
2. Cochez **"Forcer les modifications distantes sur votre dépôt local"**
3. Relancez le déploiement

**Problème**: Cela peut recréer le dépôt Git corrompu.

---

## 📋 Pourquoi FTP est Meilleur

| Critère | FTP (GitHub Actions) | Git OVH |
|---------|---------------------|---------|
| Fiabilité | ✅ Très fiable | ❌ Conflits fréquents |
| Simplicité | ✅ Simple | ❌ Complexe |
| Contrôle | ✅ Total | ❌ Limité |
| Débogage | ✅ Facile | ❌ Difficile |
| Corruption | ✅ Impossible | ❌ Possible |

---

**Recommandation**: Suivez l'Option A (Nettoyage Complet + FTP)
