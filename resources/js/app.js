import Alpine from 'alpinejs';

/**
 * Frontend entry point.
 *
 * Pages are rendered server-side with Blade and styled with Tailwind. Alpine
 * powers the small interactive bits (tab switching, collapsible forms) through
 * `x-data` / `x-show` directives, so it is bundled here instead of being pulled
 * from a third-party CDN at runtime.
 */
window.Alpine = Alpine;

Alpine.start();
