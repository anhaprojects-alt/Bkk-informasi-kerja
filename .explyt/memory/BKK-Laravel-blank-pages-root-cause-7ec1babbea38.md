---
name: "BKK-Laravel-blank-pages-root-cause"
description: "BKK Laravel13 Vercel blank pages: placeholder DB creds, APP_DEBUG=false, SESSION_DRIVER=database; diagnose db:show"
type: project
lastUpdated: 2026-09-18T20:47
---

Root cause of "pages don't display" in this BKK job-listing app.

Fact/lesson: The blank-page symptom was NOT a code bug. `.env` had placeholder DB values (DB_HOST=HOST_SUPABASE_ANDA, DB_PASSWORD=PASSWORD_SUPABASE_ANDA) with DB_CONNECTION=pgsql and SESSION_DRIVER=database, so every DB-backed request (login, register, even CSRF/sessions) failed to connect. In production, vercel.json forces APP_ENV=production and APP_DEBUG=false, so Laravel swallowed the PDOException and returned a blank page instead of an error.

**Why:** Stack is Laravel 13 / PHP 8.3 / Blade+Tailwind / Eloquent (models User, Company, JobListing, Applicant), deployed on Vercel via `api/index.php` + vercel-php. vercel.json hard-sets APP_DEBUG=false, SESSION_DRIVER=cookie, CACHE_STORE=array for prod. `api/index.php` switches DB_CONNECTION to pgsql when env('DB_HOST') is truthy, else falls back to sqlite `:memory:`. Locally `.env` instead uses SESSION_DRIVER=database + CACHE_STORE=database.

**How to apply:** When this repo shows blank pages in prod, treat it as a DB-env problem first: check DB_HOST/DB_PASSWORD are set and reachable in .env (local) or Vercel env vars, run `php artisan db:show`, or look at Vercel runtime logs. `php artisan config:clear` after any `.env` change (config caches can mask new values). App itself has no PHP errors: all 21 routes register fine.
