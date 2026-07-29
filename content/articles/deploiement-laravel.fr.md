---
title: "Déploiement d'une application Laravel"
slug: "deploiement-laravel"
excerpt: "Guide complet pour déployer votre application Laravel en production : préparation, hébergement et bonnes pratiques."
cover_image: null
category: "backend"
tags: ["Laravel", "Déploiement", "Production", "DevOps"]
status: "published"
published_at: "2026-07-13"
reading_time: 7
order: 13
meta_title: "Déploiement Laravel - Guide production"
meta_description: "Apprenez à déployer votre application Laravel en production : préparation, serveur, sécurité et optimisations."
---
## Préparation avant déploiement

### 1. Configurer l'environnement de production

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votresite.com

SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=strict
```

### 2. Générer la clé d'application
```bash
php artisan key:generate
```

### 3. Optimiser Laravel
```bash
# Cache de configuration
php artisan config:cache

# Cache de routes
php artisan route:cache

# Cache de vues
php artisan view:cache

# Optimisation des events
php artisan event:cache
```

### 4. Compiler les assets
```bash
npm install
npm run build
```

## Options d'hébergement

### Option 1 : Serveur VPS (DigitalOcean, Linode, Hetzner)

**Prérequis** : Ubuntu 22.04+, PHP 8.3+, Composer, MySQL, Nginx

Configuration Nginx :
```nginx
server {
    listen 80;
    server_name votresite.com;
    root /var/www/votresite/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known) {
        deny all;
    }
}
```

### Option 2 : Plateformes gérées

| Plateforme | Avantages | Prix |
|------------|-----------|------|
| **Laravel Forge** | Déploiement automatisé, monitoring | À partir de $12/mois |
| **Render** | Simple, SSL gratuit, scaling auto | À partir de $7/mois |
| **Fly.io** | Proche des utilisateurs, edge computing | À partir de $3/mois |
| **Platform.sh** | Environnements multiples, Git-driven | À partir de $30/mois |

### Option 3 : Hébergement partagé
- Support PHP 8.x et Composer requis
- Utilisez le dossier `public/` comme racine web
- Contraintes de performances

## Tâches récurrentes

### Mettre en place un cron pour le scheduler

```bash
# Ajouter à crontab -e
* * * * * cd /var/www/votresite && php artisan schedule:run >> /dev/null 2>&1
```

### Configurer la file d'attente

```bash
# Supervisor config pour les queues
sudo apt install supervisor
```

## Sécurité en production

- [x] `APP_DEBUG=false`
- [x] `SESSION_SECURE_COOKIE=true`
- [x] HTTPS forcé
- [x] Headers de sécurité (CSP, X-Frame-Options)
- [x] Permissions des fichiers strictes
- [x] Mises à jour régulières (composer update)
- [x] Backup de la base de données

## Monitoring

- **Laravel Telescope** (développement) / **Laravel Pulse** (production)
- **Logs** : `storage/logs/laravel.log`
- **Erreurs** : Flare, Sentry, Bugsnag

## Checklist de déploiement

- [ ] Tests passent (`php artisan test`)
- [ ] .env configuré pour la production
- [ ] `APP_DEBUG=false`
- [ ] Caches générés (config, route, view)
- [ ] Assets compilés (`npm run build`)
- [ ] HTTPS configuré
- [ ] Cron installé pour le scheduler
- [ ] Supervisor configuré pour les queues
- [ ] Backup automatisé

## Conclusion

Le déploiement est une étape cruciale. Une bonne préparation et le respect des bonnes pratiques garantissent un lancement en production sans accroc.
