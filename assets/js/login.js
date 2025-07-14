document.addEventListener("DOMContentLoaded", function () {
    let lockedOut = false;

    const loginError = document.getElementById("loginError")?.value;
    const unlockTimestampInput = document.getElementById("unlockTimestamp");
    const unlockTimestamp = unlockTimestampInput ? parseInt(unlockTimestampInput.value) : null;

    const errorMessages = {
        tooManyAttempts: "Too many failed login attempts. Try again in 3 minutes.",
        invalidCredentials: "Incorrect email or password.",
        userNotFound: "Invalid email and password."
    };

    if (loginError && errorMessages[loginError]) {
        showError("email", "");
        showError("password", errorMessages[loginError]);

        if (loginError === "tooManyAttempts" && unlockTimestamp) {
            lockedOut = true;
            disableLoginForm();

            const countdownEl = document.getElementById("countdownTimer");

            const interval = setInterval(() => {
                const now = Math.floor(Date.now() / 1000);
                const remaining = unlockTimestamp - now;

                if (remaining > 0) {
                    const mins = Math.floor(remaining / 60);
                    const secs = remaining % 60;
                    countdownEl.textContent = `Try again in ${mins}:${secs.toString().padStart(2, '0')}`;
                } else {
                    clearInterval(interval);
                    countdownEl.textContent = "";
                    enableLoginForm();
                    lockedOut = false;

                    clearFieldState("email");
                    clearFieldState("password");
                }
            }, 1000);
        }
    }

    document.getElementById("email").addEventListener("input", () => {
        const value = document.getElementById("email").value.trim();
        if (value === "") clearFieldState("email");
    });

    document.getElementById("password").addEventListener("input", () => {
        const value = document.getElementById("password").value.trim();
        if (value === "") clearFieldState("password");
    });


    // Form submission
    document.querySelector("form").addEventListener("submit", function (event) {
        if (lockedOut) return;
        clearErrors();

        const isEmailValid = validateEmail();
        const isPasswordValid = validatePassword();

        if (!isEmailValid || !isPasswordValid) {
            event.preventDefault();
        }
    });
});

// Validation
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

    const countdownEl = document.getElementById("countdownTimer");
    if (countdownEl) countdownEl.textContent = "";
}

function disableLoginForm() {
    document.getElementById("email").setAttribute("disabled", true);
    document.getElementById("password").setAttribute("disabled", true);
    const loginButton = document.querySelector("button[name='btnLogin']");
    if (loginButton) loginButton.setAttribute("disabled", true);
}

function enableLoginForm() {
    document.getElementById("email").removeAttribute("disabled");
    document.getElementById("password").removeAttribute("disabled");
    const loginButton = document.querySelector("button[name='btnLogin']");
    if (loginButton) loginButton.removeAttribute("disabled");
}
