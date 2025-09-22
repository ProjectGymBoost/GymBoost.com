document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const accountSelect = document.getElementById("accountSelect");

    // Helper to clear error and valid classes
    function clearFieldState(fieldId) {
        const input = document.getElementById(fieldId);
        const error = document.getElementById(fieldId + "Error");
        input.classList.remove("is-invalid", "is-valid");
        if (error) error.textContent = "";
    }

    // Show error message on field
    function showError(fieldId, message) {
        const input = document.getElementById(fieldId);
        const error = document.getElementById(fieldId + "Error");
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        if (error) error.textContent = message;
    }

    // Show valid state on field
    function showValid(fieldId) {
        const input = document.getElementById(fieldId);
        const error = document.getElementById(fieldId + "Error");
        input.classList.remove("is-invalid");
        input.classList.add("is-valid");
        if (error) error.textContent = "";
    }

    // Function to handle backend errors based on current account type
    function handleBackendErrors() {
        const emailExistsError = document.getElementById("emailExistsError").value;
        const rfidExistsError = document.getElementById("rfidExistsError").value;
        const selectedAccountType = accountSelect.value;

        clearFieldState("email");
        clearFieldState("rfid");

        if (
            (selectedAccountType === "user" && emailExistsError === "userEmailExists") ||
            (selectedAccountType === "admin" && emailExistsError === "adminEmailExists")
        ) {
            showError("email", "Email already exists.");
        }

        if (selectedAccountType === "user" && rfidExistsError === "userRfidExists") {
            showError("rfid", "This RFID is already in use.");
        }
    }


    const rfidContainer = document.getElementById("rfidContainer");
    const birthdayContainer = document.getElementById("birthdayContainer");
    const membershipContainer = document.getElementById("membershipContainer");

    function toggleFieldsBasedOnAccount() {
        const isAdmin = accountSelect.value === "admin";

        if (isAdmin) {
            rfidContainer.style.display = "none";
            membershipContainer.style.display = "none";

            document.getElementById("rfid").value = "";

            const membershipSelect = document.getElementById("membership");
            membershipSelect.selectedIndex = [...membershipSelect.options].findIndex(option => option.disabled);

            document.getElementById("rfid").removeAttribute("required");
            document.getElementById("membership").removeAttribute("required");

            birthdayContainer.classList.add("w-100");
        } else {
            rfidContainer.style.display = "";
            membershipContainer.style.display = "";
            document.getElementById("rfid").setAttribute("required", "required");
            document.getElementById("membership").setAttribute("required", "required");

            birthdayContainer.classList.remove("w-100");
        }
    }

    toggleFieldsBasedOnAccount();
    handleBackendErrors();

    accountSelect.addEventListener("change", function () {
        clearErrors(); 

        const isAdmin = accountSelect.value === "admin";

        if (isAdmin) {
            ["firstName", "lastName", "rfid", "membership", "email"].forEach(fieldId => {
                const field = document.getElementById(fieldId);
                field.value = "";
                clearFieldState(fieldId);
            });
        } else {
            ["firstName", "lastName", "birthday", "email", "password", "confirmPassword"].forEach(fieldId => {
                const field = document.getElementById(fieldId);
                field.value = "";
                clearFieldState(fieldId);
            });

            ["rfid", "membership"].forEach(fieldId => {
                const field = document.getElementById(fieldId);
                field.value = "";
                clearFieldState(fieldId);
            });
        }

        document.getElementById("emailExistsError").value = "";
        document.getElementById("rfidExistsError").value = "";
        toggleFieldsBasedOnAccount();
        handleBackendErrors(); 
    });

    // Mapping field IDs 
    const fieldsToValidate = {
        accountSelect: validateAccountSelect,
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

    function validateAccountSelect() {
        const field = "accountSelect";
        const value = document.getElementById(field).value;
        if (!value) {
            showError(field, "Please choose an account type.");
            return false;
        }
        showValid(field);
        return true;
    }

    function validateFirstName() {
        const field = "firstName";
        const pattern = /^[a-zA-Z-' ]*$/;
        return validatePattern(field, pattern, "Only letters and white space allowed.");
    }

    function validateLastName() {
        const field = "lastName";
        const pattern = /^[a-zA-Z-' ]*$/;
        return validatePattern(field, pattern, "Only letters and white space allowed.");
    }

    function validateEmail() {
        const field = "email";
        const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return validatePattern(field, pattern, "Invalid email format.");
    }

    function validateRFID() {
        const field = "rfid";
        const accountType = document.getElementById("accountSelect").value;

        if (accountType === "admin") {
            clearFieldState(field);
            return true;
        }

        const value = document.getElementById(field).value.trim();
        const pattern = /^[a-zA-Z0-9]*$/;

        if (!pattern.test(value)) {
            return validatePattern(field, pattern, "No special characters allowed.");
        }

        showValid(field);
        return true;
    }

    function validateBirthday() {
        const field = "birthday";
        const value = document.getElementById(field).value;
        const accountType = document.getElementById("accountSelect").value;

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
        } else if (accountType === "user" && actualAge < 12) {
            showError(field, "Member must be at least 12 years old.");
            return false;
        } else if (accountType === "admin" && actualAge < 18) {
            showError(field, "Admin must be at least 18 years old.");
            return false;
        }

        showValid(field);
        return true;
    }

    function validateMembership() {
        const field = "membership";
        const accountType = document.getElementById("accountSelect").value;

        if (accountType === "admin") {
            clearFieldState(field);
            return true;
        }

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
            showError(field, "Password must be at least 8 characters.");
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

    // Utility Functions

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

    function clearErrors() {
        document.querySelectorAll(".invalid-feedback").forEach(error => error.textContent = "");
        document.querySelectorAll("input, select").forEach(field => {
            field.classList.remove("is-invalid", "is-valid");
        });
    }

});
