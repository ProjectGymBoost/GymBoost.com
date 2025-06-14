document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    form.addEventListener("submit", function (event) {
        let valid = true;

        clearErrors();

        // Validate Email
        const emailField = document.getElementById("email");
        if (emailField) {
            const email = emailField.value;
            const validEmailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!validEmailPattern.test(email)) {
                showError("email", "Invalid email format. Please include a valid domain.");
                valid = false;
            } else {
                showValid("email");
            }
        }

        // Optional: Check password only if password field exists
        const passwordField = document.getElementById("password");
        if (passwordField) {
            const password = passwordField.value;
            if (password.length < 8) {
                showError("password", "Password must be at least 8 characters long.");
                valid = false;
            } else {
                showValid("password");
            }
        }

        const confirmPasswordField = document.getElementById("confirmPassword");
        if (confirmPasswordField && passwordField) {
            const confirmPassword = confirmPasswordField.value;
            if (passwordField.value !== confirmPassword) {
                showError("confirmPassword", "Passwords do not match.");
                valid = false;
            } else {
                showValid("confirmPassword");
            }
        }

        // Validate OTP before submitting form
        const otpField = document.getElementById("otp");
        if (otpField) {
            const userOTP = otpField.value;
            if (userOTP.length !== 6 || isNaN(userOTP)) {
                showError("otp", "OTP must be a 6-digit number.");
                valid = false;
            } else {
                showValid("otp");
            }
        }

        if (!valid) {
            event.preventDefault();
        }
    });

    function showError(field, message) {
        const inputField = document.getElementById(field);
        const errorMessage = document.getElementById(field + "Error");
        if (inputField && errorMessage) {
            inputField.classList.add("is-invalid");
            errorMessage.textContent = message;
        }
    }

    function showValid(field) {
        const inputField = document.getElementById(field);
        const errorMessage = document.getElementById(field + "Error");
        if (inputField && errorMessage) {
            inputField.classList.remove("is-invalid");
            inputField.classList.add("is-valid");
            errorMessage.textContent = "";
        }
    }

    function clearErrors() {
        const errorMessages = document.querySelectorAll(".invalid-feedback");
        errorMessages.forEach((message) => message.textContent = "");

        const inputFields = document.querySelectorAll("input");
        inputFields.forEach((field) => {
            field.classList.remove("is-invalid");
            field.classList.remove("is-valid");
        });
    }
});
