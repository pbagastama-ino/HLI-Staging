import axios from 'axios';
import { router } from '@inertiajs/vue3';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Set up CSRF token for Axios
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// Handle CSRF token expiration and session timeouts
window.axios.interceptors.response.use(
    response => response,
    error => {
        if (error.response) {
            const { status } = error.response;
            
            // Handle other server errors
            if (status >= 500) {
                showServerErrorModal();
                return Promise.reject(error);
            }
        }
        
        return Promise.reject(error);
    }
);

// Show server error modal
function showServerErrorModal() {
    const existingModal = document.querySelector('.server-error-modal');
    if (existingModal) {
        existingModal.remove();
    }
    
    const modal = document.createElement('div');
    modal.className = 'server-error-modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    modal.innerHTML = `
        <div class="bg-white rounded-lg p-6 max-w-md mx-4">
            <div class="flex items-center mb-4">
                <svg class="w-8 h-8 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
                <h3 class="text-lg font-medium text-gray-900">Server Error</h3>
            </div>
            <p class="text-gray-600 mb-4">
                A server error occurred. Please try refreshing the page or contact support if the problem persists.
            </p>
            <div class="flex justify-center">
                <button id="refreshPageError" class="px-6 py-2 bg-[#4D9F95] text-white rounded-lg hover:bg-[#3d7f75] focus:outline-none focus:ring-2 focus:ring-[#4D9F95]">
                    Refresh Page
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    // Handle refresh page
    document.getElementById('refreshPageError').addEventListener('click', () => {
        window.location.reload();
    });
    
    // Auto refresh after 10 seconds
    setTimeout(() => {
        window.location.reload();
    }, 10000);
}
