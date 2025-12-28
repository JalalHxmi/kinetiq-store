# Kinetiq — Laravel E‑Commerce Demo

## Quickstart (Local)
- Install Composer dependencies: `composer install`
- Create env: copy `.env.example` to `.env` and run `php artisan key:generate`
- Use SQLite by default: create `database/database.sqlite` file
- Run migrations and seed: `php artisan migrate --seed`
- Start server: `php artisan serve` and open `http://127.0.0.1:8000`

## Features
- Storefront with categories, products, cart, coupons, checkout
- Stripe checkout and secure webhook handling
- Cash on delivery option
- User orders dashboard, Admin panel CRUD and analytics
- Installer endpoint: `/install?secret=...`

## Stripe
- Set `STRIPE_SECRET`, `STRIPE_PUBLISHABLE`, `STRIPE_WEBHOOK_SECRET` in `.env`
- Create webhook: `checkout.session.completed` to `/api/webhook/stripe`

## Hostinger Deploy
- Upload project to root; ensure Apache points to `public/`
- Run `composer install` via SSH
- Create `.env` and `APP_KEY` (`php artisan key:generate`)
- Set DB credentials; run `php artisan migrate --seed`
- If symlink fails, storage copied by installer fallback

## CSV Import
- Admin Products page supports importing a CSV with headers: `name,category,price,stock,description`

