---
name: "BKK-blank-pages-and-build-blockers"
description: "BKK app blank pages: empty DB_* env with database session/cache driver; Vite build broke on missing bootstrap.js"
type: project
lastUpdated: 2026-09-18T23:58
lastRecall: 2026-09-19T00:05
---

Two recurring blockers that make this BKK job-listing app fail to render. Neither is a Blade/Eloquent bug.

**1. Blank pages = database env problem, not code.**
`.env` has `DB_CONNECTION=pgsql` plus `SESSION_DRIVER=database`, `CACHE_STORE=database`, `QUEUE_CONNECTION=database`. If `DB_HOST`/`DB_DATABASE`/`DB_USERNAME`/`DB_PASSWORD` are empty or placeholders, EVERY request dies (sessions/CSRF need the DB). In production `APP_DEBUG=false` swallows the PDOException, so the user sees a blank page instead of an error. `config/database.php` pgsql prefers `DB_URL`, falling back to `DATABASE_URL`.
**How to apply:** diagnose with `php artisan db:show` (it surfaces the real PDO error), then `php artisan config:clear` after any `.env` edit — config cache masks new values. The app itself is healthy: 17 routes register fine.

**2. `npm run build` failed on a dangling import.**
`resources/js/app.js` imported `./bootstrap`, but `resources/js/bootstrap.js` never existed in the repo → `[UNRESOLVED_IMPORT]`, no `public/build/manifest.json`, so every Blade view (`@vite([...])`) throws "Vite manifest not found". This ALSO breaks Railway deploys because the Dockerfile's stage 1 runs `npm run build`. Fixed on 2026-09-18 by emptying app.js (UI is Blade + Tailwind only, no JS framework).
**How to apply:** if views error on Vite manifest, run `npm ci && npm run build` locally first — a failing build here means the Docker image will fail too.

**Stack (as of 2026-09-18):** Laravel 13.32 / PHP 8.3 / Blade + Tailwind 4 / Vite 8, models User, Company, JobListing, Applicant. Deploy target is **Railway** (`Dockerfile` multi-stage + `railway.toml`, healthcheck `/up`, nginx+supervisor, port 8080). Vercel (`api/index.php` is now just a passthrough to `public/index.php`) and Supabase are legacy — Supabase was fully removed.
