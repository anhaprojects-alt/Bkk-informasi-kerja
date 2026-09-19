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

const localStorageKeys = {
    lastSearch: 'bkk.lastSearch',
    profileDraft: 'bkk.profileDraft',
};

const syncLocalProfileDraft = () => {
    const form = document.querySelector('form[action*="settings/profile"]');

    if (!form) {
        return;
    }

    const fields = form.querySelectorAll('input, textarea');

    fields.forEach((field) => {
        if (!field.name || field.type === 'file') {
            return;
        }

        const saved = JSON.parse(localStorage.getItem(localStorageKeys.profileDraft) || '{}');

        if (Object.prototype.hasOwnProperty.call(saved, field.name)) {
            field.value = saved[field.name];
        }

        field.addEventListener('input', () => {
            const draft = JSON.parse(localStorage.getItem(localStorageKeys.profileDraft) || '{}');
            draft[field.name] = field.value;
            localStorage.setItem(localStorageKeys.profileDraft, JSON.stringify(draft));
        });
    });
};

const syncLastSearch = () => {
    const searchInput = document.querySelector('input[name="q"]');
    if (!searchInput) {
        return;
    }

    const saved = localStorage.getItem(localStorageKeys.lastSearch);
    if (saved && !searchInput.value) {
        searchInput.value = saved;
    }

    searchInput.addEventListener('input', () => {
        localStorage.setItem(localStorageKeys.lastSearch, searchInput.value);
    });
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        syncLastSearch();
        syncLocalProfileDraft();
    });
} else {
    syncLastSearch();
    syncLocalProfileDraft();
}

// PWA Service Worker Registration
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .then(() => console.log('SW registered'))
            .catch(err => console.log('SW registration failed', err));
    });
}
