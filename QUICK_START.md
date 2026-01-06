# 🚀 QUICK START - DIGITA Marketing

## Configuration Rapide (5 minutes)

### ✅ Étape 1: Configurer .env

Le fichier `.env` existe déjà. **Éditer les lignes suivantes:**

```env
# Base de données - IMPORTANT: Changer waohost
DB_HOST=localhost
DB_NAME=digita_marketing
DB_USER=root
DB_PASS=

# Application
APP_URL=http://localhost
```

**Si vous utilisez WAMP/XAMPP:**
- `DB_HOST=localhost` ou `DB_HOST=127.0.0.1`

**Si vous utilisez un host virtuel:**
- Vérifier que `waohost` est dans `C:\Windows\System32\drivers\etc\hosts`
- Ou changer pour `localhost`

---

### ✅ Étape 2: Créer la Base de Données

**Option A: Via phpMyAdmin**
1. Accéder à http://localhost/phpmyadmin
2. Créer une base: `digita_marketing`
3. Charset: `utf8mb4_unicode_ci`

**Option B: Via MySQL CLI**
```sql
CREATE DATABASE digita_marketing CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

---

### ✅ Étape 3: Importer les Tables

**Dans phpMyAdmin:**
1. Sélectionner la base `digita_marketing`
2. Onglet "Importer"
3. Importer dans l'ordre:
   - `database/digita.sql`
   - `database/init.sql`
   - `database/create_blog_formations.sql`
   - `database/migrations/create_orders_tables.sql`
   - `database/migrations/add_missing_indexes.sql`

**Via MySQL CLI:**
```bash
mysql -u root -p digita_marketing < database/digita.sql
mysql -u root -p digita_marketing < database/init.sql
mysql -u root -p digita_marketing < database/create_blog_formations.sql
mysql -u root -p digita_marketing < database/migrations/create_orders_tables.sql
mysql -u root -p digita_marketing < database/migrations/add_missing_indexes.sql
```

---

### ✅ Étape 4: Tester l'Installation

```powershell
php scripts\setup\test-system.php
```

---

### ✅ Étape 5: Accéder au Site

**Frontend:**
- http://localhost (ou votre host virtuel)

**Créer un compte admin:**
1. Aller sur http://localhost/inscription
2. S'inscrire avec votre email
3. Exécuter en BDD:
```sql
UPDATE users SET role = 'admin' WHERE email = 'votre-email@domaine.com';
```

**Admin Dashboard:**
- http://localhost/admin/dashboard

---

### ✅ Étape 6: Configurer CRON (Optionnel)

**En tant qu'administrateur PowerShell:**
```powershell
.\scripts\setup\setup-cron-windows.ps1
```

Voir `CRON_SETUP.md` pour plus de détails.

---

## 🔧 Dépannage Rapide

### Erreur "Host inconnu" / "waohost"
**Solution:** Éditer `.env` et changer:
```env
DB_HOST=localhost
APP_URL=http://localhost
```

### Erreur "Access denied for user"
**Solution:** Vérifier credentials dans `.env`:
```env
DB_USER=root
DB_PASS=votre_mot_de_passe
```

### Erreur "Table doesn't exist"
**Solution:** Importer les fichiers SQL (Étape 3)

### Page blanche
**Solutions:**
1. Vérifier `logs/error.log`
2. Activer debug dans `.env`:
```env
APP_DEBUG=true
```
3. Vérifier que `mod_rewrite` est activé (Apache)

### Erreur 500
**Solutions:**
1. Vérifier permissions:
```powershell
icacls cache /grant Users:F /T
icacls logs /grant Users:F /T
```
2. Vérifier `.htaccess` existe dans `/public`

---

## 📋 Checklist Finale

- [ ] `.env` configuré avec bon DB_HOST
- [ ] Base de données créée
- [ ] Tables importées (5 fichiers SQL)
- [ ] Test système OK (`test-system.php`)
- [ ] Site accessible
- [ ] Compte admin créé
- [ ] CRON configuré (optionnel)

---

## 🎯 Configuration Minimale pour Tester

Si vous voulez juste **tester rapidement** sans tout configurer:

1. **Éditer `.env`:**
```env
DB_HOST=localhost
DB_NAME=digita_marketing
APP_URL=http://localhost
APP_DEBUG=true
```

2. **Créer BDD et importer:**
```bash
# Via phpMyAdmin ou MySQL CLI
CREATE DATABASE digita_marketing;
# Importer database/digita.sql
```

3. **Accéder:**
```
http://localhost
```

---

## 🆘 Besoin d'Aide?

**Logs à vérifier:**
- `logs/error.log`
- `logs/exception.log`

**Documentation complète:**
- `INSTALLATION.md` - Guide détaillé
- `DEPLOYMENT.md` - Déploiement production
- `FEATURES.md` - Liste fonctionnalités
- `CRON_SETUP.md` - Configuration automatisations

---

**Une fois configuré, DIGITA est prêt! 🚀**

© 2025 Digita Marketing
