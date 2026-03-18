# Laravel Cloud deployment notes

This project was cleaned for deployment:
- removed nested duplicate project folder
- removed `.env`
- removed local SQLite database file
- updated Reverb / Echo frontend config to use environment variables
- added `App\Events\GameStateUpdated` to broadcast game state updates
- controller now broadcasts on player join, team change, buzz, reset, and close

## Recommended Laravel Cloud settings

### Environment variables
Set or confirm these:
- `APP_NAME=Buzzer Game`
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://your-domain.laravel.cloud`
- `BROADCAST_CONNECTION=reverb`
- `QUEUE_CONNECTION=database`
- `SESSION_DRIVER=database`
- `CACHE_STORE=database`

When you attach a Laravel Cloud WebSockets resource, Cloud should inject:
- `REVERB_APP_ID`
- `REVERB_APP_KEY`
- `REVERB_APP_SECRET`
- `REVERB_HOST`
- `REVERB_PORT`
- `REVERB_SCHEME`
- matching `VITE_REVERB_*` vars

### Build commands
Typical build commands:
```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan optimize
```

### Deploy commands
Typical deploy commands:
```bash
php artisan migrate --force
```

### Resources
- Attach a managed database (MySQL or Postgres)
- Attach a WebSockets resource for Reverb
- No queue worker is required for the current real-time game state event because it uses `ShouldBroadcastNow`

## Important
If you change any `VITE_*` or Reverb variables, redeploy so the frontend is rebuilt with the new values.
