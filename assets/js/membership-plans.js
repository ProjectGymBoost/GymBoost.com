document.addEventListener("DOMContentLoaded", function () {

    if (window.location.search.includes('added=1')) {
        const addModal = bootstrap.Modal.getInstance(addModalEl);
        if (addModal) {
            addModalEl.addEventListener('hidden.bs.modal', function () {
                const confirmModal = new bootstrap.Modal(confirmModalEl);
                confirmModal.show();
            });
            addModal.hide();
        } else {
            const confirmModal = new bootstrap.Modal(confirmModalEl);
            confirmModal.show();
        }
    }


    const editModals = document.querySelectorAll('[id^="editMembershipPlanModal"]');

    document.querySelectorAll('[id^="editMembershipPlanModal"]').forEach((modalEl) => {
        modalEl.addEventListener('hidden.bs.modal', () => {
            modalEl.querySelectorAll('input').forEach((input) => {
                const original = input.dataset.originalValue;
                if (original !== undefined) input.value = original;

                input.classList.remove('is-invalid');
                const errorDiv = modalEl.querySelector(`#${input.id}Error`);
                if (errorDiv) errorDiv.textContent = '';
            });
        });
    });

    const addForm = document.querySelector("#addMembershipModal form");
    const addModalEl = document.getElementById("addMembershipModal");

    if (addForm && addModalEl) {
        const addFieldIDs = {
            planType: "planType",
            validity: "validity",
            price: "price",
            planTypeError: "planTypeError",
            validityError: "validityError",
            priceError: "priceError",
        };

        [addFieldIDs.planType, addFieldIDs.validity, addFieldIDs.price].forEach(fieldId => {
            const input = document.getElementById(fieldId);
            if (input) {
                input.addEventListener("input", () => clearFieldState(fieldId, fieldId + "Error"));
            }
        });

        addForm.addEventListener("submit", function (e) {
            clearErrors(addForm);
            const isPlanTypeValid = validatePlanType(addFieldIDs.planType, addFieldIDs.planTypeError);
            const isvalidityValid = validatevalidity(addFieldIDs.validity, addFieldIDs.validityError);
            const isPriceValid = validatePrice(addFieldIDs.price, addFieldIDs.priceError);

            if (!isPlanTypeValid || !isvalidityValid || !isPriceValid) {
                e.preventDefault();

                const existingModal = bootstrap.Modal.getOrCreateInstance(addModalEl);
                existingModal.show();
            }
        });


        addModalEl.addEventListener("hidden.bs.modal", function () {
            setTimeout(() => {
                addForm.reset();
                clearErrors(addForm);
                ["planType", "validity", "price"].forEach(id => {
                    clearFieldState(id, id + "Error");
                    const input = document.getElementById(id);
                    if (input) {
                        input.value = "";
                        input.classList.remove("is-invalid", "is-valid");
                    }
                });
            }, 200);
        });
    }

    function validatePlanType(fieldId, errorId) {
        const value = document.getElementById(fieldId)?.value.trim();
        if (!value) {
            showError(fieldId, errorId, "Plan type is required.");
            return false;
        }

        if (!/^[a-zA-Z0-9\-]+(?: [a-zA-Z0-9\-]+)*$/.test(value)) {
            showError(fieldId, errorId, "Plan type must not contain special characters.");
            return false;
        }

        showValid(fieldId, errorId);
        return true;
    }


    function validatevalidity(fieldId, errorId) {
        const value = document.getElementById(fieldId)?.value.trim();

        const match = value.match(/^(\d+)\s+(day|days)$/i);
        if (!match) {
            showError(fieldId, errorId, "Requires a valid number with 'day(s).'");
            return false;
        }

        const number = parseInt(match[1], 10);
        const word = match[2].toLowerCase();

        if ((number === 1 && word !== 'day') || (number !== 1 && word !== 'days')) {
            showError(fieldId, errorId, "Use 'day' for 1, 'days' for greater than 1.");
            return false;
        }
        if (!/^[a-zA-Z0-9 ]+$/.test(value)) {
            showError(fieldId, errorId, "Validity must not contain special characters.");
            return false;
        }

        showValid(fieldId, errorId);
        return true;
    }

    function validatePrice(fieldId, errorId) {
        const value = document.getElementById(fieldId)?.value.trim();

        // Regular expression that accepts:
        // - Integer or decimal with exactly 2 decimal places
        // - Thousands separator with commas
        if (!/^\d{1,3}(?:,\d{3})*(\.\d{2})?$/.test(value)) {
            showError(fieldId, errorId, "Use valid price format (600.00 or 1,200.50).");
            return false;
        }

        showValid(fieldId, errorId);
        return true;
    }


    function showError(fieldId, errorId, message) {
        const input = document.getElementById(fieldId);
        const error = document.getElementById(errorId);
        if (input) {
            input.classList.add("is-invalid");
            input.classList.remove("is-valid");
        }
        if (error) error.textContent = message;
    }

    function showValid(fieldId, errorId) {
        const input = document.getElementById(fieldId);
        const error = document.getElementById(errorId);
        if (input) {
            input.classList.remove("is-invalid");
            input.classList.add("is-valid");
        }
        if (error) error.textContent = "";
    }

    function clearFieldState(fieldId, errorId) {
        const input = document.getElementById(fieldId);
        const error = document.getElementById(errorId);
        if (input) input.classList.remove("is-invalid", "is-valid");
        if (error) error.textContent = "";
    }

    function clearErrors(form) {
        form.querySelectorAll(".invalid-feedback").forEach(el => el.textContent = "");
        form.querySelectorAll("input").forEach(input => input.classList.remove("is-invalid", "is-valid"));
    }

    document.querySelectorAll('.modal').forEach(modalEl => {
        modalEl.addEventListener("shown.bs.modal", () => {
            const form = modalEl.querySelector('form');
            if (form) {
                clearErrors(form);
            }
        });
    });

    const confirmationModals = ['confirmAddMembershipModal', 'confirmEditMembershipPlanModal', 'confirmDeleteMembershipPlanModal'];

    confirmationModals.forEach(modalId => {
        const modalEl = document.getElementById(modalId);
        if (modalEl) {
            modalEl.addEventListener('hidden.bs.modal', function () {
                document.body.style.overflow = 'auto';
                document.body.classList.remove('modal-open');
            });
        }
    });
});