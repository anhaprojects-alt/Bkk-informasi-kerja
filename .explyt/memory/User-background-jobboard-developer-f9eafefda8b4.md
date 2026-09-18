---
name: "User-background-jobboard-developer"
description: "BKK job-board dev, Indonesian speaker; confuses Supabase API keys vs Postgres DB password; needs plain-language help"
type: user
lastUpdated: 2026-09-18T20:47
lastRecall: 2026-09-18T21:01
---

The user builds and maintains the BKK job-listing web app (Laravel) and communicates in Indonesian.

Knowledge level / focus:
- Comfortable describing the app's features and scope, and working through Laravel Blade/Eloquent code.
- Has notable gaps in infrastructure/database concepts: repeatedly confused Supabase API keys (sb_publishable_/sb_secret_) with the Postgres database password, and pasted connection-string templates (`postgresql://...:<DATABASE_PASSWORD>@aws-<region>...`) as though they were finished credentials.
- Deploys the app on Vercel (see deployment memory) and manages a Supabase project.

How to tailor future collaboration:
- Keep infra/DB explanations plain-language and concrete; explicitly contrast credential types (API key vs host vs password) rather than assuming the distinction is known.
- Verify that values provided are real and not placeholders (`[YOUR-PASSWORD]`, `<region>`, `sb_...` keys) before trusting them; when they're placeholders, say so directly and point to where the real value lives.
- Step-by-step dashboard navigation (e.g. Supabase → Project Settings → Database → Reset database password) is welcome and effective.
