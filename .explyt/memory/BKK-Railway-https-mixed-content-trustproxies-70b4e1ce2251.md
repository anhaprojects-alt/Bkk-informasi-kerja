---
name: "BKK-Railway-https-mixed-content-trustproxies"
description: "Unstyled BKK pages on Railway: missing trustProxies made Laravel emit http:// asset URLs blocked as mixed content"
type: project
lastUpdated: 2026-09-19T00:35
---

Symptom: the deployed BKK app at `*.up.railway.app` rendered with NO styling at all (serif font, blue underlined links) even though `npm run build` succeeded and the CSS existed.

**Root cause:** `bootstrap/app.php` had an empty `withMiddleware()` — no `trustProxies`. Railway terminates TLS at its edge and forwards to the container over plain HTTP with `X-Forwarded-Proto: https`. Laravel therefore believed the request was insecure and rendered every `@vite` asset URL as `http://...`, which the browser blocked as **mixed content** on the `https://` page. The assets themselves were fine — fetching the CSS over https returned 200 / 32 kB / `text/css`.

**Fix (commit 7ed08e1):** `$middleware->trustProxies(at: '*');` in `bootstrap/app.php`.

**How to diagnose this class of bug fast:** fetch the live page and grep the HTML for the asset URLs (`Invoke-WebRequest` + regex on `href=/src=`). If they say `http://` while the page is `https://`, it is always the proxy-trust issue — not a build, manifest or Vite problem. Do not go hunting in `vite.config.js`.

**Related cross-browser hardening added in the same commit:**
- `viewport-fit=cover` was missing from all 9 Blade views, so the `env(safe-area-inset-*)` padding used by the bottom nav resolved to 0 on notched iPhones.
- Tailwind 4 emits `oklch` (52×), `color-mix` (6×) and `@property` (45×); explicit Vite `build.target` of chrome111/edge111/firefox128/safari16.4 matches that floor and shrank the CSS from 54.6 kB to 36.5 kB.
- The desktop shell in `resources/css/app.css` is built entirely on `:has()` (Firefox <121 lacks it); an `@supports not selector(:has(*))` block keeps the mobile fallback readable.
- Mobile inputs pinned to 16px because iOS zooms the viewport when a focused field is smaller.
