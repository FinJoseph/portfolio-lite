---
title: "Fampandehanana ny Laravel amin'ny production"
slug: "deploiement-laravel"
excerpt: "Tari-dalana feno hametrahana ny application Laravel amin'ny production: fiomanana, hosting ary fomba tsara."
cover_image: null
category: "backend"
tags: ["Laravel", "Fampandehanana", "Production", "DevOps"]
status: "published"
published_at: "2026-07-13"
reading_time: 7
order: 13
meta_title: "Fampandehanana Laravel - Tari-dalana production"
meta_description: "Ianaro ny fametrahana ny application Laravel amin'ny production: fiomanana, mpizara, fiarovana ary optimisation."
---
## Fiomanana alohan'ny fampandehanana

### 1. Configuration tontolo production

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tranokalanao.com

SESSION_SECURE_COOKIE=true
```

### 2. Optimiser Laravel
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

### 3. Compiler ny assets
```bash
npm install
npm run build
```

## Safidy hosting

### Safidy 1: VPS (DigitalOcean, Linode, Hetzner)
Ubuntu 22.04+, PHP 8.3+, Composer, MySQL, Nginx

### Safidy 2: Plateforme mitantana

| Plateforme | Tombontsoa | Vidiny |
|------------|-----------|--------|
| **Laravel Forge** | Fametrahana mandeha ho azy | $12/volana |
| **Render** | Tsotra, SSL maimaim-poana | $7/volana |
| **Fly.io** | Edge computing | $3/volana |
| **Platform.sh** | Tontolo maro | $30/volana |

## Fiarovana amin'ny production

- [ ] `APP_DEBUG=false`
- [ ] HTTPS terena
- [ ] Headers fiarovana (CSP, X-Frame-Options)
- [ ] Fanavaozana tsy tapaka
- [ ] Backup database

## Lisitry ny fampandehanana

- [ ] Tests mandalo (`php artisan test`)
- [ ] .env voaomana ho an'ny production
- [ ] `APP_DEBUG=false`
- [ ] Cache voaforona
- [ ] Assets voaomana (`npm run build`)
- [ ] HTTPS voaomana
- [ ] Cron napetraka
