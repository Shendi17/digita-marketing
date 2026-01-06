# 📦 Guide d'Installation - DIGITA Marketing

## Prérequis

- **PHP** 8.2 ou supérieur
- **MySQL** 8.0 ou supérieur
- **Composer** (gestionnaire de dépendances PHP)
- **Serveur Web** (Apache/Nginx avec mod_rewrite)
- **Node.js** (optionnel, pour optimisations frontend)

## Installation Étape par Étape

### 1. Cloner le Projet

```bash
git clone https://github.com/votre-repo/digita-marketing.git
cd digita-marketing
```

### 2. Installer les Dépendances PHP

```bash
composer install
```

**Dépendances principales:**
- `stripe/stripe-php` - Paiements Stripe
- `phpmailer/phpmailer` - Envoi d'emails
- `tecnickcom/tcpdf` - Génération PDF
- `phpoffice/phpspreadsheet` - Export Excel

### 3. Configuration de l'Environnement

Copier le fichier `.env.example` vers `.env`:

```bash
copy .env.example .env
```

Éditer `.env` et configurer:

```env
# Application
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-domaine.com

# Base de données
DB_HOST=localhost
DB_NAME=digita_marketing
DB_USER=votre_user
DB_PASS=votre_password

# Email
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre-email@gmail.com
MAIL_PASSWORD=votre-app-password
ADMIN_EMAIL=admin@digita.fr

# Stripe (Paiements)
STRIPE_PUBLIC_KEY=pk_live_votre_cle_publique
STRIPE_SECRET_KEY=sk_live_votre_cle_secrete
STRIPE_WEBHOOK_SECRET=whsec_votre_webhook_secret

# Analytics
GA_TRACKING_ID=G-XXXXXXXXXX
FB_PIXEL_ID=votre_pixel_id

# OpenAI (IA)
OPENAI_API_KEY=sk-votre_cle_api
OPENAI_MODEL=gpt-4
```

### 4. Créer la Base de Données

```sql
CREATE DATABASE digita_marketing CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 5. Importer les Tables

```bash
mysql -u votre_user -p digita_marketing < database/digita.sql
mysql -u votre_user -p digita_marketing < database/init.sql
mysql -u votre_user -p digita_marketing < database/create_blog_formations.sql
```

### 6. Exécuter les Migrations

```bash
mysql -u votre_user -p digita_marketing < database/migrations/create_orders_tables.sql
mysql -u votre_user -p digita_marketing < database/migrations/add_missing_indexes.sql
```

### 7. Configuration du Serveur Web

#### Apache (.htaccess déjà configuré)

Vérifier que `mod_rewrite` est activé:

```bash
a2enmod rewrite
systemctl restart apache2
```

#### Nginx

Exemple de configuration:

```nginx
server {
    listen 80;
    server_name votre-domaine.com;
    root /var/www/digita-marketing/public;
    
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
    
    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### 8. Permissions des Dossiers

```bash
chmod -R 755 public/
chmod -R 775 cache/
chmod -R 775 logs/
chmod -R 775 backups/
```

### 9. Configurer les Tâches CRON

Éditer le crontab:

```bash
crontab -e
```

Ajouter les tâches:

```cron
# Nettoyage cache (quotidien 2h)
0 2 * * * php /var/www/digita-marketing/scripts/cron/clear-cache.php

# Backup BDD (quotidien 3h)
0 3 * * * php /var/www/digita-marketing/scripts/cron/backup-database.php

# Optimisation BDD (hebdomadaire dimanche 3h)
0 3 * * 0 php /var/www/digita-marketing/scripts/cron/optimize-database.php

# Génération sitemap (quotidien 4h)
0 4 * * * php /var/www/digita-marketing/scripts/cron/generate-sitemap.php

# Newsletter (lundi 10h)
0 10 * * 1 php /var/www/digita-marketing/scripts/cron/send-newsletter.php
```

### 10. Configurer SSL (Production)

Avec Let's Encrypt:

```bash
certbot --apache -d votre-domaine.com -d www.votre-domaine.com
```

### 11. Créer un Compte Admin

Accéder à `/inscription` et créer un compte, puis mettre à jour le rôle en BDD:

```sql
UPDATE users SET role = 'admin' WHERE email = 'votre-email@domaine.com';
```

### 12. Configurer Stripe Webhooks

Dans le dashboard Stripe, ajouter un webhook vers:

```
https://votre-domaine.com/checkout/webhook
```

Événements à écouter:
- `checkout.session.completed`
- `payment_intent.succeeded`
- `payment_intent.payment_failed`

### 13. Vérifications Finales

✅ Accéder à `https://votre-domaine.com`  
✅ Tester la connexion admin  
✅ Vérifier les emails (formulaire contact)  
✅ Tester un paiement test Stripe  
✅ Vérifier Google Analytics  
✅ Tester le PWA (manifest + service worker)  

## Optimisations Production

### Cache PHP (OPcache)

Dans `php.ini`:

```ini
opcache.enable=1
opcache.memory_consumption=256
opcache.max_accelerated_files=20000
opcache.validate_timestamps=0
```

### Compression Gzip

Dans `.htaccess` (déjà configuré):

```apache
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript
</IfModule>
```

### CDN (Optionnel)

Configurer Cloudflare ou AWS CloudFront pour les assets statiques.

## Dépannage

### Erreur 500

- Vérifier les logs: `tail -f logs/error.log`
- Vérifier permissions dossiers
- Vérifier configuration `.env`

### Emails non envoyés

- Vérifier credentials SMTP dans `.env`
- Tester avec un compte Gmail + App Password
- Vérifier logs: `tail -f logs/error.log`

### Base de données

- Vérifier connexion: `mysql -u user -p`
- Vérifier tables: `SHOW TABLES;`
- Vérifier charset: `SHOW CREATE DATABASE digita_marketing;`

## Support

Pour toute question: support@digita.fr

---

© 2025 Digita Marketing - Tous droits réservés
