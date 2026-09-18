---
name: "BKK-stack-railway-firebase-no-supabase"
description: "BKK stack decision: Railway (hosting + Postgres) + Firebase only; Supabase config, disk and npm deps removed"
type: project
lastUpdated: 2026-09-18T23:59
---

Decision (2026-09-18, by the user): the BKK job-listing app uses **Railway + Firebase only**. Supabase is abandoned and was fully removed from the repo.

Removed in that cleanup:
- `config/supabase.php` (deleted) — held SUPABASE_URL / anon_key / service_role_key and REST/Auth/Storage/Functions endpoints.
- The `supabase` S3 disk in `config/filesystems.php` (deleted) — remaining disks are `local`, `public`, `s3`.
- npm deps `@supabase/ssr` and `@supabase/supabase-js` (no JS code ever imported them).
- Leftover `AWS_*` storage vars in `.env` / `.env.example`.

**Why:** applicant CVs are never uploaded server-side — `JobController` validates `'resume' => ['required','string','max:2048']`, i.e. a plain URL (Google Drive / Firebase Storage link). So no object-storage credentials are needed at all, and keeping the Supabase disk/config only invited the API-key-vs-DB-password confusion that previously blocked the deploy.

**Current roles:** Railway = hosting + PostgreSQL (`Dockerfile` + `railway.toml`). Firebase = client-side features only (`config/firebase.php`, phone/OTP reset in `resources/views/auth/forgot-password.blade.php`); FIREBASE_* + VITE_FIREBASE_* live in `.env`.

**How to apply:** do not reintroduce Supabase packages, config or disks. For DB credentials use Railway's Postgres service → Variables → `DATABASE_PUBLIC_URL` (`*.proxy.rlwy.net`), NOT `postgres.railway.internal` — the internal host is unreachable from a local machine. Note: the DB password is inside that connection string, and is a different credential from any platform API token.
