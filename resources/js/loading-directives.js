// Alpine.js directives for loading states

// Button loading directive
// Usage: x-button-loading="Loading text..."
// Example: <button x-button-loading="Saving...">Save</button>
document.addEventListener('alpine:init', () => {
    Alpine.directive('button-loading', (el, { expression }, { effect, evaluateLater }) => {
        const getLoadingText = evaluateLater(expression || 'Loading...');
        
        let originalText = el.innerText;
        let originalDisabled = el.disabled;
        let isLoading = false;

        const setLoading = (loading) => {
            isLoading = loading;
            
            if (loading) {
                originalText = el.innerText;
                originalDisabled = el.disabled;
                
                el.disabled = true;
                el.classList.add('btn-loading');
                
                // Add spinner
                const spinner = document.createElement('span');
                spinner.className = 'btn-spinner';
                spinner.innerHTML = `
                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                `;
                
                getLoadingText((text) => {
                    el.innerHTML = '';
                    el.appendChild(spinner);
                    const textSpan = document.createElement('span');
                    textSpan.className = 'ml-2';
                    textSpan.textContent = text;
                    el.appendChild(textSpan);
                });
            } else {
                el.disabled = originalDisabled;
                el.classList.remove('btn-loading');
                el.innerHTML = originalText;
            }
        };

        // Listen for form submission if button is in a form
        const form = el.closest('form');
        if (form) {
            form.addEventListener('submit', () => {
                setLoading(true);
            });

            // Reset on completion (you can also listen for specific events)
            window.addEventListener('pageshow', () => {
                if (isLoading) setLoading(false);
            });
        }

        // Also allow manual control via x-data
        el._x_buttonLoading = setLoading;
    });

    // Form loading directive
    // Usage: x-form-loading
    // Disables all inputs and buttons during form submission
    Alpine.directive('form-loading', (el, {}, { effect }) => {
        if (el.tagName !== 'FORM') return;

        let isSubmitting = false;

        const disableForm = () => {
            isSubmitting = true;
            
            // Disable all inputs
            const inputs = el.querySelectorAll('input, select, textarea, button');
            inputs.forEach(input => {
                input.dataset.originalDisabled = input.disabled;
                input.disabled = true;
            });

            // Add loading class to form
            el.classList.add('form-submitting');
        };

        const enableForm = () => {
            isSubmitting = false;
            
            // Re-enable all inputs
            const inputs = el.querySelectorAll('input, select, textarea, button');
            inputs.forEach(input => {
                if (input.dataset.originalDisabled === 'false') {
                    input.disabled = false;
                } else if (input.dataset.originalDisabled === undefined) {
                    input.disabled = false;
                }
                delete input.dataset.originalDisabled;
            });

            // Remove loading class
            el.classList.remove('form-submitting');
        };

        el.addEventListener('submit', (e) => {
            // Prevent duplicate submissions
            if (isSubmitting) {
                e.preventDefault();
                return false;
            }
            // Disable form but allow submission to proceed
            setTimeout(() => disableForm(), 0);
        });

        // Re-enable on page show (for back button)
        window.addEventListener('pageshow', () => {
            if (isSubmitting) enableForm();
        });

        // Also allow manual control
        el._x_formLoading = {
            disable: disableForm,
            enable: enableForm
        };
    });

    // Prevent double-click directive
    // Usage: x-prevent-double-click
    Alpine.directive('prevent-double-click', (el) => {
        let lastClick = 0;
        const clickThreshold = 500; // ms
        let isSubmitting = false;

        el.addEventListener('click', (e) => {
            const now = Date.now();
            
            // If already submitting, prevent the click
            if (isSubmitting) {
                e.preventDefault();
                e.stopPropagation();
                return false;
            }
            
            // If this is a rapid double-click, prevent it
            if (now - lastClick < clickThreshold) {
                e.preventDefault();
                e.stopPropagation();
                return false;
            }
            
            lastClick = now;
            
            // If this is a form or button, mark as submitting after a short delay
            if (el.tagName === 'FORM' || el.tagName === 'BUTTON' || el.type === 'submit') {
                setTimeout(() => {
                    isSubmitting = true;
                }, 100);
            }
        });

        // Reset submitting state when page loads
        window.addEventListener('pageshow', () => {
            isSubmitting = false;
            lastClick = 0;
        });
    });
});
