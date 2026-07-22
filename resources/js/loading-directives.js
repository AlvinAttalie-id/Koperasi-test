const spinner = `
    <svg class="loading-button__spinner animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true">
        <circle class="opacity-25" cx="12" cy="12" r="9" stroke="currentColor" stroke-width="3"></circle>
        <path class="opacity-90" fill="currentColor" d="M12 3a9 9 0 0 0-9 9h3a6 6 0 0 1 6-6V3Z"></path>
    </svg>`;

const loadingTextFor = (button) => {
    if (button.dataset.loadingText) return button.dataset.loadingText;

    const label = button.textContent.trim().toLowerCase();
    if (label.includes('register')) return 'Registering...';
    if (label.includes('update')) return 'Updating...';
    if (label.includes('delete')) return 'Deleting...';
    if (label.includes('login') || label.includes('sign in')) return 'Signing In...';
    if (label.includes('apply')) return 'Applying...';
    if (label.includes('save')) return 'Saving...';
    return 'Loading...';
};

const setButtonLoading = (button, loading) => {
    if (!button) return;

    if (loading) {
        if (!button.dataset.originalContent) button.dataset.originalContent = button.innerHTML;
        if (!button.dataset.originalDisabled) button.dataset.originalDisabled = String(button.disabled);
        button.disabled = true;
        button.setAttribute('aria-busy', 'true');
        button.classList.add('is-loading');
        button.innerHTML = `${spinner}<span>${loadingTextFor(button)}</span>`;
        return;
    }

    if (button.dataset.originalContent) button.innerHTML = button.dataset.originalContent;
    button.disabled = button.dataset.originalDisabled === 'true';
    button.removeAttribute('aria-busy');
    button.classList.remove('is-loading');
};

const lockForm = (form) => {
    const scope = form.closest('[data-loading-modal]') || form;
    const controls = scope.querySelectorAll('input, select, textarea, button');
    const submitter = form._loadingSubmitter || form.querySelector('[type="submit"]');

    scope.dataset.loading = 'true';
    form.dataset.loading = 'true';
    controls.forEach((control) => {
        if (!control.dataset.originalDisabled) control.dataset.originalDisabled = String(control.disabled);
        control.disabled = true;
    });
    setButtonLoading(submitter, true);
    form.classList.add('form-submitting');
};

const unlockForm = (form) => {
    const scope = form.closest('[data-loading-modal]') || form;
    scope.querySelectorAll('input, select, textarea, button').forEach((control) => {
        control.disabled = control.dataset.originalDisabled === 'true';
        delete control.dataset.originalDisabled;
    });
    setButtonLoading(form._loadingSubmitter, false);
    delete scope.dataset.loading;
    delete form.dataset.loading;
    form.classList.remove('form-submitting');
};

/**
 * Shared async-action controller for fetch/AJAX actions. It ignores repeat
 * calls while pending and emits the application's standard toast event.
 */
export const useAsyncAction = () => {
    const state = { loading: false, error: null, success: false };

    return {
        state,
        get loading() { return state.loading; },
        get error() { return state.error; },
        get success() { return state.success; },
        async execute(action, { successMessage, errorMessage } = {}) {
            if (state.loading) return;
            state.loading = true;
            state.error = null;
            state.success = false;

            try {
                const result = await action();
                state.success = true;
                if (successMessage) window.dispatchEvent(new CustomEvent('toast', { detail: { message: successMessage, variant: 'success' } }));
                return result;
            } catch (error) {
                state.error = error;
                window.dispatchEvent(new CustomEvent('toast', { detail: { message: errorMessage || 'Something went wrong. Please try again.', variant: 'error' } }));
                throw error;
            } finally {
                state.loading = false;
            }
        },
    };
};

window.useAsyncAction = useAsyncAction;
window.LoadingButton = { setLoading: setButtonLoading };

document.addEventListener('submit', (event) => {
    const form = event.target;
    if (!(form instanceof HTMLFormElement) || form.hasAttribute('data-no-loading')) return;

    if (form.dataset.loading) {
        event.preventDefault();
        event.stopImmediatePropagation();
        return;
    }

    form._loadingSubmitter = event.submitter || form.querySelector('button[type="submit"], input[type="submit"]');
    form.dataset.loading = 'pending';
    setButtonLoading(form._loadingSubmitter, true);
    window.LoadingManager?.start();
    // The form remains serializable for the browser's current submit event;
    // controls are disabled in the next task while the request is underway.
    window.setTimeout(() => lockForm(form), 0);
}, true);

window.addEventListener('pageshow', () => {
    document.querySelectorAll('form[data-loading="true"]').forEach(unlockForm);
});
