# 🚀 Guide de Déploiement - DIGITA Marketing

## Checklist Pré-Déploiement

### Sécurité

- [ ] Fichier `.env` configuré avec credentials production
- [ ] `APP_DEBUG=false` dans `.env`
- [ ] Fichiers sensibles supprimés (`create_admin.php`, etc.)
- [ ] Permissions correctes sur les dossiers
- [ ] SSL/HTTPS configuré
- [ ] Firewall configuré
- [ ] Rate limiting activé

### Base de Données

- [ ] Backup de la BDD existante
- [ ] Migrations exécutées
- [ ] Index créés
- [ ] Tables optimisées
- [ ] Compte admin créé

### Configuration

- [ ] Stripe configuré (clés production)
- [ ] Webhooks Stripe configurés
- [ ] Google Analytics configuré
- [ ] Facebook Pixel configuré
- [ ] SMTP configuré et testé
- [ ] OpenAI API configurée (si utilisée)

### Performance

- [ ] OPcache activé
- [ ] Compression Gzip activée
- [ ] Cache configuré
- [ ] CDN configuré (optionnel)
- [ ] Images optimisées

### Automatisations

- [ ] Tâches CRON configurées
- [ ] Backups automatiques testés
- [ ] Newsletter testée
- [ ] Sitemap généré

## Déploiement sur Serveur Partagé (cPanel)

### 1. Préparer les Fichiers

```bash
# Créer une archive
tar -czf digita-marketing.tar.gz .
```

### 2. Upload via FTP/SFTP

- Uploader l'archive dans le dossier `public_html`
- Extraire: `tar -xzf digita-marketing.tar.gz`

### 3. Configuration cPanel

- **PHP Version**: Sélectionner PHP 8.2+
- **PHP Extensions**: Activer `mysqli`, `pdo_mysql`, `curl`, `gd`, `mbstring`
- **Créer BDD**: Via phpMyAdmin
- **Importer SQL**: Via phpMyAdmin

### 4. Configuration .htaccess

Le `.htaccess` est déjà configuré, vérifier juste le `RewriteBase`:

```apache
RewriteBase /
```

## Déploiement sur VPS (Ubuntu/Debian)

### 1. Préparer le Serveur

```bash
# Mise à jour
sudo apt update && sudo apt upgrade -y

# Installer LAMP
sudo apt install apache2 mysql-server php8.2 php8.2-mysql php8.2-curl php8.2-gd php8.2-mbstring php8.2-xml php8.2-zip -y

# Installer Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

### 2. Configurer MySQL

```bash
sudo mysql_secure_installation

# Créer utilisateur et BDD
sudo mysql
CREATE DATABASE digita_marketing;
CREATE USER 'digita_user'@'localhost' IDENTIFIED BY 'mot_de_passe_fort';
GRANT ALL PRIVILEGES ON digita_marketing.* TO 'digita_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 3. Cloner et Configurer

```bash
cd /var/www
sudo git clone https://github.com/votre-repo/digita-marketing.git
cd digita-marketing
sudo composer install --no-dev --optimize-autoloader
sudo cp .env.example .env
sudo nano .env  # Configurer
```

### 4. Permissions

```bash
sudo chown -R www-data:www-data /var/www/digita-marketing
sudo chmod -R 755 /var/www/digita-marketing
sudo chmod -R 775 /var/www/digita-marketing/cache
sudo chmod -R 775 /var/www/digita-marketing/logs
```

### 5. Configuration Apache

```bash
sudo nano /etc/apache2/sites-available/digita-marketing.conf
```

```apache
<VirtualHost *:80>
    ServerName votre-domaine.com
    ServerAlias www.votre-domaine.com
    DocumentRoot /var/www/digita-marketing/public
    
    <Directory /var/www/digita-marketing/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/digita_error.log
    CustomLog ${APACHE_LOG_DIR}/digita_access.log combined
</VirtualHost>
```

```bash
sudo a2ensite digita-marketing.conf
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### 6. SSL avec Let's Encrypt

```bash
sudo apt install certbot python3-certbot-apache -y
sudo certbot --apache -d votre-domaine.com -d www.votre-domaine.com
```

## Déploiement Docker

### Dockerfile

```dockerfile
FROM php:8.2-apache

# Extensions PHP
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Activer mod_rewrite
RUN a2enmod rewrite

# Copier les fichiers
COPY . /var/www/html/

# Permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

EXPOSE 80
```

### docker-compose.yml

```yaml
version: '3.8'

services:
  web:
    build: .
    ports:
      - "80:80"
    volumes:
      - .:/var/www/html
    depends_on:
      - db
    environment:
      - APP_ENV=production
      
  db:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: root_password
      MYSQL_DATABASE: digita_marketing
      MYSQL_USER: digita_user
      MYSQL_PASSWORD: digita_password
    volumes:
      - db_data:/var/lib/mysql

volumes:
  db_data:
```

```bash
docker-compose up -d
```

## Monitoring Post-Déploiement

### 1. Vérifier les Logs

```bash
tail -f logs/error.log
tail -f /var/log/apache2/error.log
```

### 2. Tester les Fonctionnalités

- [ ] Page d'accueil charge
- [ ] Connexion admin fonctionne
- [ ] Formulaire contact envoie email
- [ ] Paiement test Stripe fonctionne
- [ ] PWA installable
- [ ] Analytics tracking

### 3. Performance

```bash
# Test de charge
ab -n 1000 -c 10 https://votre-domaine.com/

# Temps de réponse
curl -w "@curl-format.txt" -o /dev/null -s https://votre-domaine.com/
```

### 4. Sécurité

```bash
# Scanner SSL
https://www.ssllabs.com/ssltest/

# Scanner sécurité
https://observatory.mozilla.org/
```

## Rollback en Cas de Problème

### 1. Restaurer BDD

```bash
mysql -u user -p digita_marketing < backups/database/backup_YYYY-MM-DD.sql
```

### 2. Restaurer Fichiers

```bash
git checkout main
git pull origin main
composer install
```

## Maintenance Continue

### Backups

- **BDD**: Quotidien automatique (CRON)
- **Fichiers**: Hebdomadaire
- **Stockage**: Local + Cloud (S3/Backblaze)

### Mises à Jour

```bash
# Pull dernières modifications
git pull origin main

# Mettre à jour dépendances
composer update

# Exécuter migrations si nécessaire
mysql -u user -p digita_marketing < database/migrations/nouvelle_migration.sql

# Vider cache
php scripts/cron/clear-cache.php
```

### Monitoring

- **Uptime**: UptimeRobot, Pingdom
- **Erreurs**: Sentry
- **Performance**: New Relic, DataDog
- **Analytics**: Google Analytics, Matomo

## Support

En cas de problème: support@digita.fr

---

© 2025 Digita Marketing
