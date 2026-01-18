function showToast(message, type = 'success') {
    const toastEl = document.getElementById('appToast');
    const toastMessage = document.getElementById('toastMessage');
    const toastIcon = document.getElementById('toastIcon');

    toastEl.className = `toast align-items-center text-white border-0 bg-${type}`;
    
    // Icon Logic
    const icons = { 'success': 'bi-check-circle', 'danger': 'bi-exclamation-octagon', 'warning': 'bi-exclamation-triangle' };
    toastIcon.className = `bi me-2 ${icons[type] || 'bi-info-circle'}`;

    toastMessage.innerText = message;

    const toast = new bootstrap.Toast(toastEl, { delay: 5000 });
    toast.show();
}

document.addEventListener('DOMContentLoaded', function () {
    const params = new URLSearchParams(window.location.search);
    
    // Now we look for 'status' (the color) and 'msg' (the text)
    if (params.has('status') && params.has('msg')) {
        const status = params.get('status'); // e.g., 'danger'
        const message = params.get('msg');   // e.g., 'Invalid ID'
        
        showToast(decodeURIComponent(message), status);

        // Clean URL
        const cleanUrl = window.location.origin + window.location.pathname;
        window.history.replaceState({}, document.title, cleanUrl);
    }
});