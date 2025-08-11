document.addEventListener("DOMContentLoaded", function () {
    const loginError = document.getElementById("loginError")?.textContent.trim();

    const errorMessages = {
        invalidCredentials: "Incorrect email or password.",
        userNotFound: "Invalid email and password.",
        accountInactive: "Account inactive. Please visit the front desk."
    };

    if (loginError && errorMessages[loginError]) {
        showError("email", "");
        showError("password", errorMessages[loginError]);
    }

    document.getElementById("email").addEventListener("input", () => {
        const value = document.getElementById("email").value.trim();
        if (value === "") clearFieldState("email");
    });

    document.getElementById("password").addEventListener("input", () => {
        const value = document.getElementById("password").value.trim();
        if (value === "") clearFieldState("password");
    });

    document.querySelector("form").addEventListener("submit", function (event) {
        clearErrors();

        const isEmailValid = validateEmail();
        const isPasswordValid = validatePassword();

        if (!isEmailValid || !isPasswordValid) {
            event.preventDefault();
        }
    });
});

// Validation and helpers (unchanged)
function validateEmail() {
    const field = "email";
    const value = document.getElementById(field).value.trim();
    const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!pattern.test(value)) {
        showError(field, "Invalid email format.");
        return false;
    }
    showValid(field);
    return true;
}

function validatePassword() {
    const field = "password";
    const value = document.getElementById(field).value.trim();

    if (value.length < 8) {
        showError(field, "Invalid password.");
        return false;
    }
    showValid(field);
    return true;
}

function showError(field, message) {
    const inputField = document.getElementById(field);
    const errorMessage = document.getElementById(field + "Error");

    inputField.classList.add("is-invalid");
    inputField.classList.remove("is-valid");
    errorMessage.textContent = message;
}

function showValid(field) {
    const inputField = document.getElementById(field);
    const errorMessage = document.getElementById(field + "Error");

    inputField.classList.remove("is-invalid");
    inputField.classList.add("is-valid");
    errorMessage.textContent = "";
}

function clearFieldState(field) {
    const inputField = document.getElementById(field);
    const errorMessage = document.getElementById(field + "Error");

    inputField.classList.remove("is-invalid", "is-valid");
    errorMessage.textContent = "";
}

function clearErrors() {
    document.querySelectorAll(".invalid-feedback").forEach(el => {
        el.textContent = "";
    });

    document.querySelectorAll("input").forEach(input => {
        input.classList.remove("is-invalid", "is-valid");
    });
}
