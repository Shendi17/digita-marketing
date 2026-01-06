# ⏰ Configuration des Tâches CRON - DIGITA Marketing

## Vue d'Ensemble

DIGITA utilise 5 tâches CRON automatisées pour maintenir le système en autopilot.

---

## 📋 Liste des Tâches CRON

### 1. Nettoyage du Cache (Quotidien - 2h)
**Script**: `scripts/cron/clear-cache.php`  
**Fréquence**: Tous les jours à 2h du matin  
**Actions**:
- Supprime les fichiers de cache expirés (>24h)
- Nettoie les sessions expirées
- Supprime les logs anciens (>90 jours)

### 2. Backup Base de Données (Quotidien - 3h)
**Script**: `scripts/cron/backup-database.php`  
**Fréquence**: Tous les jours à 3h du matin  
**Actions**:
- Crée un dump MySQL complet
- Compresse en .gz
- Supprime les backups >30 jours
- Stocke dans `backups/database/`

### 3. Optimisation BDD (Hebdomadaire - Dimanche 3h)
**Script**: `scripts/cron/optimize-database.php`  
**Fréquence**: Tous les dimanches à 3h du matin  
**Actions**:
- ANALYZE toutes les tables
- OPTIMIZE toutes les tables
- Affiche statistiques BDD

### 4. Génération Sitemap (Quotidien - 4h)
**Script**: `scripts/cron/generate-sitemap.php`  
**Fréquence**: Tous les jours à 4h du matin  
**Actions**:
- Génère sitemap.xml
- Inclut pages statiques
- Inclut articles blog
- Inclut formations

### 5. Envoi Newsletter (Hebdomadaire - Lundi 10h)
**Script**: `scripts/cron/send-newsletter.php`  
**Fréquence**: Tous les lundis à 10h du matin  
**Actions**:
- Récupère abonnés actifs
- Compile derniers articles/formations
- Envoie newsletter HTML
- Log résultats

---

## 🖥️ Configuration Windows (PowerShell)

### Méthode 1: Task Scheduler (Recommandé)

#### Script PowerShell de Configuration

Créer: `scripts/setup/setup-cron-windows.ps1`

```powershell
# Configuration automatique des tâches planifiées Windows
$projectPath = "C:\Users\Anthony\CascadeProjects\digita-marketing"
$phpPath = "C:\php\php.exe"  # Ajuster selon votre installation

# Fonction pour créer une tâche
function Create-ScheduledTask {
    param($Name, $Script, $Time, $Days)
    
    $action = New-ScheduledTaskAction -Execute $phpPath -Argument "$projectPath\$Script"
    $trigger = New-ScheduledTaskTrigger -Weekly -DaysOfWeek $Days -At $Time
    $principal = New-ScheduledTaskPrincipal -UserId "$env:USERDOMAIN\$env:USERNAME" -LogonType S4U
    $settings = New-ScheduledTaskSettingsSet -AllowStartIfOnBatteries -DontStopIfGoingOnBatteries
    
    Register-ScheduledTask -TaskName "DIGITA_$Name" -Action $action -Trigger $trigger -Principal $principal -Settings $settings -Force
    Write-Host "✓ Tâche créée: DIGITA_$Name"
}

Write-Host "Configuration des tâches CRON pour DIGITA Marketing..." -ForegroundColor Cyan

# 1. Nettoyage cache (quotidien 2h)
Create-ScheduledTask -Name "ClearCache" -Script "scripts\cron\clear-cache.php" -Time "02:00" -Days @("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday")

# 2. Backup BDD (quotidien 3h)
Create-ScheduledTask -Name "BackupDB" -Script "scripts\cron\backup-database.php" -Time "03:00" -Days @("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday")

# 3. Optimisation BDD (dimanche 3h)
Create-ScheduledTask -Name "OptimizeDB" -Script "scripts\cron\optimize-database.php" -Time "03:00" -Days @("Sunday")

# 4. Génération sitemap (quotidien 4h)
Create-ScheduledTask -Name "GenerateSitemap" -Script "scripts\cron\generate-sitemap.php" -Time "04:00" -Days @("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday")

# 5. Newsletter (lundi 10h)
Create-ScheduledTask -Name "SendNewsletter" -Script "scripts\cron\send-newsletter.php" -Time "10:00" -Days @("Monday")

Write-Host "`n✅ Toutes les tâches CRON configurées!" -ForegroundColor Green
Write-Host "Vérifier dans: Panneau de configuration > Outils d'administration > Planificateur de tâches" -ForegroundColor Yellow
```

#### Exécution

```powershell
# En tant qu'administrateur
Set-ExecutionPolicy RemoteSigned -Scope CurrentUser
.\scripts\setup\setup-cron-windows.ps1
```

### Méthode 2: Tâches Manuelles

Ouvrir **Planificateur de tâches** → **Créer une tâche de base**

**Exemple pour Backup BDD:**
1. **Nom**: DIGITA_BackupDB
2. **Déclencheur**: Quotidien à 3h
3. **Action**: Démarrer un programme
   - Programme: `C:\php\php.exe`
   - Arguments: `C:\Users\Anthony\CascadeProjects\digita-marketing\scripts\cron\backup-database.php`
4. **Terminer**

Répéter pour les 5 tâches.

---

## 🐧 Configuration Linux/Ubuntu

### Éditer Crontab

```bash
crontab -e
```

### Ajouter les Tâches

```cron
# DIGITA Marketing - Tâches automatisées

# Nettoyage cache (quotidien 2h)
0 2 * * * /usr/bin/php /var/www/digita-marketing/scripts/cron/clear-cache.php >> /var/www/digita-marketing/logs/cron.log 2>&1

# Backup BDD (quotidien 3h)
0 3 * * * /usr/bin/php /var/www/digita-marketing/scripts/cron/backup-database.php >> /var/www/digita-marketing/logs/cron.log 2>&1

# Optimisation BDD (dimanche 3h)
0 3 * * 0 /usr/bin/php /var/www/digita-marketing/scripts/cron/optimize-database.php >> /var/www/digita-marketing/logs/cron.log 2>&1

# Génération sitemap (quotidien 4h)
0 4 * * * /usr/bin/php /var/www/digita-marketing/scripts/cron/generate-sitemap.php >> /var/www/digita-marketing/logs/cron.log 2>&1

# Newsletter (lundi 10h)
0 10 * * 1 /usr/bin/php /var/www/digita-marketing/scripts/cron/send-newsletter.php >> /var/www/digita-marketing/logs/cron.log 2>&1
```

### Vérifier les Tâches

```bash
crontab -l
```

---

## 🍎 Configuration macOS

Identique à Linux, utiliser `crontab -e`

---

## 🧪 Tester les Scripts Manuellement

### Windows (PowerShell)

```powershell
# Tester backup BDD
php scripts\cron\backup-database.php

# Tester nettoyage cache
php scripts\cron\clear-cache.php

# Tester optimisation BDD
php scripts\cron\optimize-database.php

# Tester génération sitemap
php scripts\cron\generate-sitemap.php

# Tester newsletter
php scripts\cron\send-newsletter.php
```

### Linux/macOS

```bash
# Tester backup BDD
php scripts/cron/backup-database.php

# Tester nettoyage cache
php scripts/cron/clear-cache.php

# etc...
```

---

## 📊 Monitoring des Tâches

### Vérifier les Logs

**Windows:**
```powershell
Get-Content logs\cron.log -Tail 50
```

**Linux/macOS:**
```bash
tail -f logs/cron.log
```

### Vérifier les Backups

```bash
ls -lh backups/database/
```

### Vérifier le Sitemap

Accéder à: `https://votre-domaine.com/sitemap.xml`

---

## ⚠️ Dépannage

### Les Tâches ne s'exécutent pas

**Windows:**
1. Vérifier dans Planificateur de tâches
2. Vérifier l'historique des tâches
3. Vérifier les permissions utilisateur
4. Vérifier le chemin PHP

**Linux:**
1. Vérifier crontab: `crontab -l`
2. Vérifier logs système: `grep CRON /var/log/syslog`
3. Vérifier permissions scripts: `chmod +x scripts/cron/*.php`
4. Vérifier chemin PHP: `which php`

### Erreurs dans les Scripts

Consulter les logs:
```bash
tail -f logs/error.log
tail -f logs/cron.log
```

---

## 🔐 Sécurité

### Permissions Recommandées

**Linux:**
```bash
chmod 755 scripts/cron/*.php
chmod 775 backups/
chmod 775 logs/
```

**Windows:**
- Scripts: Lecture/Exécution pour utilisateur système
- Backups/Logs: Écriture pour utilisateur système

### Rotation des Logs

Ajouter une tâche mensuelle:

```cron
# Rotation logs (1er du mois à 1h)
0 1 1 * * find /var/www/digita-marketing/logs -name "*.log" -mtime +90 -delete
```

---

## 📈 Optimisations

### Ajuster les Horaires

Adapter selon votre trafic:
- **Faible trafic**: Exécuter pendant heures creuses
- **Fort trafic**: Espacer les tâches lourdes

### Notifications

Ajouter notifications email en cas d'erreur:

```php
// Dans chaque script CRON
if ($error) {
    mail(ADMIN_EMAIL, 'Erreur CRON', $errorMessage);
}
```

---

## ✅ Checklist Configuration

- [ ] Scripts CRON créés dans `scripts/cron/`
- [ ] Tâches planifiées configurées (Windows/Linux)
- [ ] Chemins PHP corrects
- [ ] Permissions fichiers/dossiers OK
- [ ] Tests manuels réussis
- [ ] Logs vérifiés
- [ ] Backups testés
- [ ] Sitemap généré
- [ ] Newsletter testée (mode test)

---

**Une fois configuré, DIGITA tourne en autopilot! 🚀**

© 2025 Digita Marketing
