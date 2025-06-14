document.addEventListener("DOMContentLoaded", function () {
    const loginErrorInput = document.getElementById("loginError");

    // Login Errors
    if (loginErrorInput) {
        const loginError = loginErrorInput.value;
        const errorMessages = {
            tooManyAttempts: "Too many failed login attempts. Try again in 5 minutes.",
            invalidCredentials: "Incorrect email or password.",
            userNotFound: "User doesn't exist."
        };

        if (errorMessages[loginError]) {
            showError("email", "");
            showError("password", errorMessages[loginError], true);
        }
    }
});


document.querySelector("form").addEventListener("submit", function (event) {
    let valid = true;
    clearErrors();

    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    //Set error messages
    if (!emailPattern.test(email)) {
        showError("email", "Invalid email format.");
        valid = false;
    } else {
        showValid("email");
    }

    if (password.length < 8) {
        showError("password", "Invalid password. Password must be at least 8 characters.");
        valid = false;
    } else {
        showValid("password");
    }

    if (!valid) event.preventDefault();
});

// Show error message with optional styling
function showError(field, message, applyBgColor) {
    const inputField = document.getElementById(field);
    const errorMessage = document.getElementById(field + "Error");
    
    inputField.classList.add("is-invalid");
    errorMessage.textContent = message;

    if (applyBgColor) {
        errorMessage.style.backgroundColor = "#f8d7da";
        errorMessage.style.padding = "8px";
        errorMessage.style.marginTop = "8px";
        errorMessage.style.borderRadius = "5px";
    }
}

// Show valid state
function showValid(field) {
    const inputField = document.getElementById(field);
    inputField.classList.remove("is-invalid");
    inputField.classList.add("is-valid");
    document.getElementById(field + "Error").textContent = "";
}

// Clear previous errors
function clearErrors() {
    document.querySelectorAll(".invalid-feedback").forEach(function (el) {
        el.style.backgroundColor = "";
        el.style.padding = "";
        el.style.borderRadius = "";
        el.textContent = "";
    });

    document.querySelectorAll("input").forEach(function (input) {
        input.classList.remove("is-invalid", "is-valid");
    });
}
