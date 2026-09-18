---
name: "Supabase-DB-setup-pending-password"
description: "Supabase setup: project hfzsykrwfwjgoqxzwkmp, pooler host; sb_publishable/sb_secret keys not DB password; unfilled"
type: project
lastUpdated: 2026-09-18T20:47
---

Ongoing Supabase DB setup (state as of 2026-09-18), NOT yet connected — the Postgres password is still unfilled.

Facts:
- Real database project is `hfzsykrwfwjgoqxzwkmp`. Do NOT confuse with `rfgkaptjjjpnkosftjkk` (the project the SUPABASE_URL originally pointed to — the two are different Supabase projects; that mismatch caused auth failures).
- Connection (pooler, session): host `aws-0-ap-southeast-1.pooler.supabase.com`, port 5432, database `postgres`, username `postgres.hfzsykrwfwjgoqxzwkmp`, sslmode require. config/database.php pgsql driver prefers `DB_URL`, falling back to POSTGRES_URL_NON_POOLING_2/POSTGRES_URL_NON_POOLING. A direct host `db.hfzsykrwfwjgoqxzwkmp.supabase.co:5432` was also confirmed reachable.
- Key gotcha: Supabase API keys (SUPABASE_PUBLISHABLE_KEY `sb_publishable_...`, SUPABASE_SECRET_KEY `sb_secret_...`) authenticate the Auth/REST API only. They are NOT the Postgres database password and CANNOT be used as DB_PASSWORD — Laravel's Eloquent connects directly to Postgres and will fail with `password authentication failed for user "postgres"`. The user repeatedly supplied API keys / connection-string templates as if they were the DB password; they are three distinct credentials.
- As of 2026-09-18, DB_PASSWORD and DB_URL still contain placeholder `ISI_PASSWORD_DATABASE_DISINI`; user chose to fill the real password later in the .env/Vercel editor. Migrations have NOT been run yet.

**Why:** This was the blockers chain for getting the app to render: blank pages → DB env → hosting mismatch → missing real password. Prevents re-diagnosing from scratch.

**How to apply:** Get the real password from Supabase Dashboard → Project Settings → Database → Connection string → Show password (or Reset database password). URL-encode special chars (`@`→%40, `:`, `/`) in DB_URL. After filling: `php artisan config:clear` + `php artisan db:show` + `php artisan migrate`. Mirror the DB_* + SUPABASE_* vars in Vercel env for the deployed site.
