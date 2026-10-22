#!/bin/bash
set -e

echo "🚀 Starting deploy process..."

# 1. Set website to maintenance mode
php artisan down --retry=10 || echo "Site is already down"

# 2. Update code from git
git pull origin master

# 3. Install PHP requirements
# use --no-interaction, to skip questions
composer install --no-dev --optimize-autoloader --no-interaction

# 4. Frontend
pnpm install --frozen-lockfile
pnpm run build

# 5. Database migrations

php artisan migrate --force

# 6. Optimize laravel cache
php artisan optimize
php artisan view:cache
php artisan event:cache

# 7. Update Filament assets
php artisan filament:upgrade

# 8. Clear custom cache
php artisan app:clear-all-cache || echo "Custom cache clear skipped"

# 9. Horizon (if used)
if php artisan list | grep -q 'horizon:terminate'; then
    php artisan horizon:terminate
fi

# 10. Set website to live mode
php artisan up

echo "✅ Deploy success! Site is live."
