document.addEventListener("DOMContentLoaded", function () {
    if (window.location.search.includes('added=1')) {
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
        const confirmModal = new bootstrap.Modal(document.getElementById('confirmAddMembershipModal'));
        confirmModal.show();
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
            requirement: "requirement",
            price: "price",
            planTypeError: "planTypeError",
            requirementError: "requirementError",
            priceError: "priceError",
        };

        [addFieldIDs.planType, addFieldIDs.requirement, addFieldIDs.price].forEach(fieldId => {
            const input = document.getElementById(fieldId);
            if (input) {
                input.addEventListener("input", () => clearFieldState(fieldId, fieldId + "Error"));
            }
        });

        addForm.addEventListener("submit", function (e) {
            clearErrors(addForm);
            const isPlanTypeValid = validatePlanType(addFieldIDs.planType, addFieldIDs.planTypeError);
            const isRequirementValid = validateRequirement(addFieldIDs.requirement, addFieldIDs.requirementError);
            const isPriceValid = validatePrice(addFieldIDs.price, addFieldIDs.priceError);

            if (!isPlanTypeValid || !isRequirementValid || !isPriceValid) {
                e.preventDefault();
                new bootstrap.Modal(addModalEl).show();
            }
        });

        addModalEl.addEventListener("hidden.bs.modal", function () {
            setTimeout(() => {
                addForm.reset();
                clearErrors(addForm);
                ["planType", "requirement", "price"].forEach(id => {
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
        if (!/^[a-zA-Z0-9]+(?: [a-zA-Z0-9]+)*$/.test(value)) {
            showError(fieldId, errorId, "Plan type must not contain special characters.");
            return false;
        }
        showValid(fieldId, errorId);
        return true;
    }

    function validateRequirement(fieldId, errorId) {
        const value = document.getElementById(fieldId)?.value.trim();
        if (!/^\d+\s*days$/i.test(value)) {
            showError(fieldId, errorId, "Requirement must include a valid number followed by 'day(s)'.");
            return false;
        }
        if (!/^[a-zA-Z0-9]+(?: [a-zA-Z0-9]+)*$/.test(value)) {
            showError(fieldId, errorId, "Plan type must not contain special characters.");
            return false;
        }
        showValid(fieldId, errorId);
        return true;
    }

    function validatePrice(fieldId, errorId) {
        const value = document.getElementById(fieldId)?.value.trim();
        if (!/^\d+\.00$/.test(value)) {
            showError(fieldId, errorId, "Price must end with .00 (e.g., 100.00).");
            return false;
        }
        if (!/^[a-zA-Z0-9]+(?: [a-zA-Z0-9]+)*$/.test(value)) {
            showError(fieldId, errorId, "Plan type must not contain special characters.");
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
});
