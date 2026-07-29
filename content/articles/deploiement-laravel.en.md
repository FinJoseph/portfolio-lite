---
title: "Deploying a Laravel Application"
slug: "deploiement-laravel"
excerpt: "Complete guide to deploying your Laravel application to production: preparation, hosting and best practices."
cover_image: null
category: "backend"
tags: ["Laravel", "Deployment", "Production", "DevOps"]
status: "published"
published_at: "2026-07-13"
reading_time: 7
order: 13
meta_title: "Laravel Deployment - Production Guide"
meta_description: "Learn how to deploy your Laravel application to production: preparation, server, security and optimizations."
---
## Pre-deployment Preparation

### 1. Configure Production Environment

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yoursite.com

SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=strict
```

### 2. Generate Application Key
```bash
php artisan key:generate
```

### 3. Optimize Laravel
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

### 4. Compile Assets
```bash
npm install
npm run build
```

## Hosting Options

### Option 1: VPS Server (DigitalOcean, Linode, Hetzner)

**Requirements**: Ubuntu 22.04+, PHP 8.3+, Composer, MySQL, Nginx

### Option 2: Managed Platforms

| Platform | Benefits | Pricing |
|------------|-----------|------|
| **Laravel Forge** | Automated deployment, monitoring | From $12/month |
| **Render** | Simple, free SSL, auto-scaling | From $7/month |
| **Fly.io** | Edge computing, close to users | From $3/month |
| **Platform.sh** | Multi-environment, Git-driven | From $30/month |

## Regular Tasks

### Set up cron for scheduler

```bash
# Add to crontab -e
* * * * * cd /var/www/yoursite && php artisan schedule:run >> /dev/null 2>&1
```

## Production Security

- [ ] `APP_DEBUG=false`
- [ ] `SESSION_SECURE_COOKIE=true`
- [ ] Force HTTPS
- [ ] Security headers (CSP, X-Frame-Options)
- [ ] Strict file permissions
- [ ] Regular updates (composer update)
- [ ] Database backups

## Deployment Checklist

- [ ] Tests pass (`php artisan test`)
- [ ] .env configured for production
- [ ] `APP_DEBUG=false`
- [ ] Caches generated (config, route, view)
- [ ] Assets compiled (`npm run build`)
- [ ] HTTPS configured
- [ ] Cron installed for scheduler
- [ ] Queue workers configured
- [ ] Automated backups
