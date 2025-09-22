document.addEventListener("DOMContentLoaded", function () {
    const editModals = document.querySelectorAll('[id^="editMembershipPlanModal"]');

    // for resetting the form and removing validation when the user manually closes the modal
    editModals.forEach((modalEl) => {
        modalEl.addEventListener('hidden.bs.modal', () => {
            modalEl.querySelectorAll('input').forEach((input) => {
                const original = input.dataset.originalValue;
                if (original !== undefined) input.value = original;

                input.classList.remove('is-invalid', 'is-valid');
                const errorDiv = modalEl.querySelector(`#${input.id}Error`);
                if (errorDiv) errorDiv.textContent = '';
            });
        });
    });

    // General listener for all modals to clear states upon manual closing
    document.querySelectorAll('.modal').forEach(modalEl => {
        modalEl.addEventListener("hidden.bs.modal", () => {
            const form = modalEl.querySelector('form');
            if (form) {
                // Remove all invalid and valid classes from inputs
                form.querySelectorAll("input").forEach(input => {
                    input.classList.remove("is-invalid", "is-valid");
                });
                // Clear all invalid feedback messages
                form.querySelectorAll(".invalid-feedback").forEach(el => el.textContent = "");
            }
        });
    });

});