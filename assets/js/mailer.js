document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    // Real-time Validation 
    const fieldsToValidate = {};

    if (document.getElementById("email")) {
        fieldsToValidate.email = validateEmail;
    }
    if (document.getElementById("password")) {
        fieldsToValidate.password = validatePassword;
    }
    if (document.getElementById("confirmPassword")) {
        fieldsToValidate.confirmPassword = validateConfirmPassword;
    }
    if (document.getElementById("otp")) {
        fieldsToValidate.otp = validateOTP;
    }


    for (const [fieldId, validator] of Object.entries(fieldsToValidate)) {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener("input", () => {
                if (field.value.trim() === "") {
                    clearFieldState(fieldId);
                } else {
                    validator();
                }
            });
        }
    }

    // On form submission
    form.addEventListener("submit", function (event) {
        let valid = true;

        clearErrors();

        for (const validator of Object.values(fieldsToValidate)) {
            if (!validator()) {
                valid = false;
            }
        }

        if (!valid) {
            event.preventDefault();
        }
    });

    // Validation Functions 

    function validateEmail() {
        const field = "email";
        const email = document.getElementById(field).value.trim();
        const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!pattern.test(email)) {
            showError(field, "Invalid email format. Please include a valid domain.");
            return false;
        }
        showValid(field);
        return true;
    }

    function validatePassword() {
        const field = "password";
        const password = document.getElementById(field)?.value || "";
        if (password.length < 8) {
            showError(field, "Password must be at least 8 characters long.");
            return false;
        }
        showValid(field);
        return true;
    }

    function validateConfirmPassword() {
        const password = document.getElementById("password")?.value || "";
        const confirmPassword = document.getElementById("confirmPassword")?.value || "";
        if (password !== confirmPassword) {
            showError("confirmPassword", "Passwords do not match.");
            return false;
        }
        showValid("confirmPassword");
        return true;
    }

    function validateOTP() {
        const field = "otp";
        const otp = document.getElementById(field)?.value || "";
        if (otp.length !== 6 || isNaN(otp)) {
            showError(field, "OTP must be a 6-digit number.");
            return false;
        }
        showValid(field);
        return true;
    }

    function showError(fieldId, message) {
        const input = document.getElementById(fieldId);
        const error = document.getElementById(fieldId + "Error");
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        if (error) error.textContent = message;
    }

    function showValid(fieldId) {
        const input = document.getElementById(fieldId);
        const error = document.getElementById(fieldId + "Error");
        input.classList.remove("is-invalid");
        input.classList.add("is-valid");
        if (error) error.textContent = "";
    }

    function clearFieldState(fieldId) {
        const input = document.getElementById(fieldId);
        const error = document.getElementById(fieldId + "Error");
        input.classList.remove("is-invalid", "is-valid");
        if (error) error.textContent = "";
    }

    function clearErrors() {
        document.querySelectorAll(".invalid-feedback").forEach(err => err.textContent = "");
        document.querySelectorAll("input").forEach(input => {
            input.classList.remove("is-invalid", "is-valid");
        });
    }
});
