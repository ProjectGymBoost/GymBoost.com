document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    const emailExistsError = document.getElementById("emailExistsError")?.value;
    const rfidExistsError = document.getElementById("rfidExistsError")?.value;

    if (emailExistsError === "emailExists") {
        showError("email", "Email already exists.");
    }

    if (rfidExistsError === "rfidExists") {
        showError("rfid", "This RFID is already linked to another account.");
    }

    // Mapping field IDs 
    const fieldsToValidate = {
        firstName: validateFirstName,
        lastName: validateLastName,
        email: validateEmail,
        rfid: validateRFID,
        birthday: validateBirthday,
        membership: validateMembership,
        password: validatePassword,
        confirmPassword: validateConfirmPassword
    };

    // Real-time input validation
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

        for (const validate of Object.values(fieldsToValidate)) {
            if (!validate()) {
                valid = false;
            }
        }

        if (!valid) {
            event.preventDefault();
        }
    });

    // Validation Functions

    function validateFirstName() {
        const field = "firstName";
        const value = document.getElementById(field).value.trim();
        const pattern = /^[a-zA-Z-' ]*$/;
        return validatePattern(field, pattern, "Only letters and white space allowed.");
    }

    function validateLastName() {
        const field = "lastName";
        const value = document.getElementById(field).value.trim();
        const pattern = /^[a-zA-Z-' ]*$/;
        return validatePattern(field, pattern, "Only letters and white space allowed.");
    }

    function validateEmail() {
        const field = "email";
        const value = document.getElementById(field).value.trim();
        const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return validatePattern(field, pattern, "Invalid email format. Please include a valid domain.");
    }

    function validateRFID() {
        const field = "rfid";
        const value = document.getElementById(field).value.trim();
        const pattern = /^\d{10}$/;
        return validatePattern(field, pattern, "RFID must be 10 digits.");
    }

    function validateBirthday() {
        const field = "birthday";
        const value = document.getElementById(field).value;
        if (!value) {
            showError(field, "Please enter your birthday.");
            return false;
        }

        const birthDate = new Date(value);
        const today = new Date();
        const age = today.getFullYear() - birthDate.getFullYear();
        const m = today.getMonth() - birthDate.getMonth();
        const isBirthdayPassed = m > 0 || (m === 0 && today.getDate() >= birthDate.getDate());
        const actualAge = isBirthdayPassed ? age : age - 1;

        if (birthDate >= today) {
            showError(field, "Birthday must be in the past.");
            return false;
        } else if (actualAge < 12) {
            showError(field, "Member must be at least 12 years old.");
            return false;
        }

        showValid(field);
        return true;
    }

    function validateMembership() {
        const field = "membership";
        const value = document.getElementById(field).value;
        if (!value || value === "Membership Plan") {
            showError(field, "Please select a membership plan.");
            return false;
        }
        showValid(field);
        return true;
    }

    function validatePassword() {
        const field = "password";
        const value = document.getElementById(field).value;
        if (value.length < 8) {
            showError(field, "Password must be at least 8 characters long.");
            return false;
        }
        showValid(field);
        return true;
    }

    function validateConfirmPassword() {
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirmPassword").value;
        if (password !== confirmPassword) {
            showError("confirmPassword", "Passwords do not match.");
            return false;
        }
        showValid("confirmPassword");
        return true;
    }

    //  Utility Functions 

    function validatePattern(fieldId, pattern, errorMsg) {
        const field = document.getElementById(fieldId);
        const value = field.value.trim();
        if (!pattern.test(value)) {
            showError(fieldId, errorMsg);
            return false;
        }
        showValid(fieldId);
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
        document.querySelectorAll(".invalid-feedback").forEach(error => error.textContent = "");
        document.querySelectorAll("input, select").forEach(field => {
            field.classList.remove("is-invalid", "is-valid");
        });
    }
});
