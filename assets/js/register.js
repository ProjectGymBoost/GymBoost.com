document.addEventListener("DOMContentLoaded", function () {

    const emailExistsError = document.getElementById("emailExistsError").value;

    // Show emailExistsError if present.
    if (emailExistsError === "emailExists") {
        showError("email", "Email already exists.");
    }

    const form = document.querySelector("form");
    form.addEventListener("submit", function (event) {
        let valid = true;

        // Clear previous error messages.
        clearErrors();

        // Validate First Name.
        const firstName = document.getElementById("firstName").value;
        if (!/^[a-zA-Z-' ]*$/.test(firstName)) {
            showError("firstName", "Only letters and white space allowed.");
            valid = false;
        } else {
            showValid("firstName");
        }

        // Validate Last Name.
        const lastName = document.getElementById("lastName").value;
        if (!/^[a-zA-Z-' ]*$/.test(lastName)) {
            showError("lastName", "Only letters and white space allowed.");
            valid = false;
        } else {
            showValid("lastName");
        }

        //Validate Email
        const email = document.getElementById("email").value;
        const validEmailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!validEmailPattern.test(email)) {
            showError("email", "Invalid email format. Please include a valid domain.");
            valid = false;
        } else {
            showValid("email");
        }

        // Validate Membership Selection
        const membership = document.getElementById("membership").value;
        if (!membership || membership === "Membership Plan") {
            showError("membership", "Please select a membership plan.");
            valid = false;
        } else {
            showValid("membership");
        }

        // Validate Password Length.
        const password = document.getElementById("password").value;
        if (password.length < 8) {
            showError("password", "Password must be at least 8 characters long.");
            valid = false;
        } else {
            showValid("password");
        }

        // Validate Password Confirmation.
        const confirmPassword = document.getElementById("confirmPassword").value;
        if (password !== confirmPassword) {
            showError("confirmPassword", "Passwords do not match.");
            valid = false;
        } else {
            showValid("confirmPassword");
        }

        // If not valid, prevent form submission.
        if (!valid) {
            event.preventDefault();
        }
    });
    // Function to show error message (turns field red).
    function showError(field, message) {
        const inputField = document.getElementById(field);
        const errorMessage = document.getElementById(field + "Error");
        inputField.classList.add("is-invalid");
        errorMessage.textContent = message;
    }

    // Function to show valid input (turns field green).
    function showValid(field) {
        const inputField = document.getElementById(field);
        const errorMessage = document.getElementById(field + "Error");
        inputField.classList.remove("is-invalid");
        inputField.classList.add("is-valid");
        errorMessage.textContent = "";
    }

    // Function to clear previous error messages.
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