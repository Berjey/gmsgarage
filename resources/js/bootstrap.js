// CSRF token for fetch() requests
const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
if (token) {
    window._csrfToken = token;
}
