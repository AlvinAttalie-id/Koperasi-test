import NProgress from 'nprogress';
import 'nprogress/nprogress.css';

// Configure NProgress
NProgress.configure({
    minimum: 0.1,
    easing: 'ease',
    speed: 500,
    showSpinner: false,
    trickleSpeed: 200,
    parent: 'body'
});

// Loading state management
const LoadingManager = {
    isLoading: false,
    loadingStartTime: null,
    loadingTimeout: null,
    overlayTimeout: null,
    minDisplayTime: 150, // Minimum display time to prevent flashing

    // Start loading indicators
    start() {
        if (this.isLoading) return;
        
        this.isLoading = true;
        this.loadingStartTime = Date.now();

        // Start NProgress immediately
        NProgress.start();
        
        // Add cursor progress
        this.addCursorProgress();

        // Show overlay after a small delay to prevent flashing on fast requests
        this.overlayTimeout = setTimeout(() => {
            if (this.isLoading) {
                this.showOverlay();
            }
        }, this.minDisplayTime);
    },

    // Stop loading indicators
    stop() {
        if (!this.isLoading) return;

        const elapsed = Date.now() - this.loadingStartTime;
        const remainingTime = this.minDisplayTime - elapsed;

        // Ensure minimum display time
        if (remainingTime > 0) {
            setTimeout(() => {
                this.completeLoading();
            }, remainingTime);
        } else {
            this.completeLoading();
        }
    },

    // Complete loading process
    completeLoading() {
        clearTimeout(this.overlayTimeout);
        
        NProgress.done();
        this.hideOverlay();
        this.removeCursorProgress();
        
        this.isLoading = false;
        this.loadingStartTime = null;
    },

    // Show full-page overlay
    showOverlay() {
        const overlay = document.getElementById('loading-overlay');
        if (overlay) {
            overlay.classList.remove('opacity-0', 'pointer-events-none');
            overlay.classList.add('opacity-100');
        }
    },

    // Hide full-page overlay
    hideOverlay() {
        const overlay = document.getElementById('loading-overlay');
        if (overlay) {
            overlay.classList.remove('opacity-100');
            overlay.classList.add('opacity-0', 'pointer-events-none');
        }
    },

    // Add cursor progress to body
    addCursorProgress() {
        document.body.classList.add('cursor-progress');
    },

    // Remove cursor progress from body
    removeCursorProgress() {
        document.body.classList.remove('cursor-progress');
    }
};

// Initialize loading indicators on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    // Intercept all link clicks for navigation
    document.addEventListener('click', (e) => {
        const link = e.target.closest('a');
        
        if (!link) return;
        
        // Skip if:
        // - Link has target="_blank"
        // - Link has data-no-loading attribute
        // - Link is a hash link
        // - Link is a javascript link
        // - Link has download attribute
        if (
            link.target === '_blank' ||
            link.hasAttribute('data-no-loading') ||
            link.href.startsWith('#') ||
            link.href.startsWith('javascript:') ||
            link.hasAttribute('download')
        ) {
            return;
        }

        // Check if link is to same origin
        if (link.origin !== window.location.origin) {
            return;
        }

        // Start loading for same-origin navigation
        LoadingManager.start();
    });

    // Intercept form submissions
    document.addEventListener('submit', (e) => {
        const form = e.target;
        
        // Skip if form has data-no-loading attribute
        if (form.hasAttribute('data-no-loading')) {
            return;
        }

        // Don't interfere with form submission - let it proceed naturally
        // The browser will handle navigation and page load events
    });

    // Listen for Alpine.js navigation if using Alpine.navigate
    if (window.Alpine) {
        document.addEventListener('alpine:navigate', () => {
            LoadingManager.start();
        });

        document.addEventListener('alpine:navigated', () => {
            LoadingManager.stop();
        });
    }

    // Handle page visibility changes (tab switching)
    document.addEventListener('visibilitychange', () => {
        if (document.hidden && LoadingManager.isLoading) {
            LoadingManager.stop();
        }
    });

    // Handle browser back/forward buttons
    window.addEventListener('popstate', () => {
        LoadingManager.start();
    });

    // Stop loading when page is fully loaded
    window.addEventListener('load', () => {
        LoadingManager.stop();
    });
});

// Export for use in other modules if needed
window.LoadingManager = LoadingManager;
