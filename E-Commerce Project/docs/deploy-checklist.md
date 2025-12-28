# Deploy Checklist
- Ensure web root points to `public/`
- Set correct file permissions for `storage` and `bootstrap/cache`
- Configure `.env` with `APP_KEY`, database credentials, and Stripe keys
- Run `composer install --no-dev`
- Run `php artisan migrate --force`
- Set up Stripe webhook to `/api/webhook/stripe`
- Configure mail sender in `.env`
