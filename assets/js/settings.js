document.addEventListener("DOMContentLoaded", function () {

  // ========== PROFILE INFO: FULL NAME ==========

  const profileUpdatedFlag = document.getElementById("profileUpdatedFlag")?.value;
  if (profileUpdatedFlag === "true") {
    const confirmNameModalEl = document.getElementById("confirmNameModal");
    const confirmNameModal = bootstrap.Modal.getOrCreateInstance(confirmNameModalEl);
    setTimeout(() => confirmNameModal.show(), 300);
  }

  const nameModalEl = document.getElementById("editNameModal");
  const nameForm = document.getElementById("editNameForm");

  let nameFormSaved = false;

  nameForm.addEventListener("submit", function (e) {
    const isValid = validateFirstAndLastName();
    if (!isValid) {
      e.preventDefault();
      nameFormSaved = false;
      return;
    }

    nameFormSaved = true;
    const modal = bootstrap.Modal.getOrCreateInstance(nameModalEl);
    modal.hide();
  });

  nameModalEl.addEventListener("hidden.bs.modal", function () {
    if (!nameFormSaved) {
      nameForm.reset();
      clearErrors(nameForm);
    }
    nameFormSaved = false;
  });

  // Validate firstName and lastName inputs separately
  function validateFirstAndLastName() {
    let valid = true;
    clearErrors(nameForm);

    const firstName = document.getElementById("firstName").value.trim();
    const lastName = document.getElementById("lastName").value.trim();
    const nameRegex = /^[a-zA-Z-' ]+$/;

    if (!firstName) {
      showError("firstName", "First name is required.");
      valid = false;
    } else if (!nameRegex.test(firstName)) {
      showError("firstName", "Only letters and white space allowed.");
      valid = false;
    } else {
      showValid("firstName");
    }

    if (!lastName) {
      showError("lastName", "Last name is required.");
      valid = false;
    } else if (!nameRegex.test(lastName)) {
      showError("lastName", "Only letters and white space allowed.");
      valid = false;
    } else {
      showValid("lastName");
    }

    return valid;
  }

  // ========== EDIT PASSWORD MODAL ==========

  const editPassModalEl = document.getElementById("editAccountPassModal");
  const confirmPassModalEl = document.getElementById("confirmEditPassModal");
  const passForm = document.getElementById("editAccountPassForm");
  const savePassChangesBtn = document.getElementById("saveAccountChangesBtn");
  const editPassModal = bootstrap.Modal.getOrCreateInstance(editPassModalEl);
  const confirmPassModal = bootstrap.Modal.getOrCreateInstance(confirmPassModalEl);
  const currentPasswordErrorInput = document.getElementById("currentPasswordErrorValue");
  const currentPasswordErrorValue = currentPasswordErrorInput ? currentPasswordErrorInput.value : null;
  const accountUpdatedFlag = document.getElementById("accountUpdatedFlag")?.value;

  var emailModal = document.getElementById('editAccountEmailModal');
  var otpModal = document.getElementById('otpModal');

  if (emailModal) {
    emailModal.addEventListener('shown.bs.modal', function () {
      var emailInput = document.getElementById('email');
      if (emailInput) emailInput.focus();
    });
  }

  if (otpModal) {
    otpModal.addEventListener('shown.bs.modal', function () {
      var otpInput = document.getElementById('otp');
      if (otpInput) otpInput.focus();
    });
  }

  if (currentPasswordErrorValue) {
    editPassModal.show();
    showError("currentPassword", currentPasswordErrorValue);
  } else if (accountUpdatedFlag === "true") {
    setTimeout(() => confirmPassModal.show(), 300);
  }

  savePassChangesBtn.addEventListener("click", function (e) {
    e.preventDefault();
    const isValid = validatePasswordForm();
    if (isValid) passForm.submit();
  });

  editPassModalEl.addEventListener("hidden.bs.modal", function () {
    clearFormFields(passForm);
    clearErrors(passForm);
    ["currentPassword", "newPassword", "confirmPassword"].forEach(field => {
      document.getElementById(field)?.classList.remove("is-valid", "is-invalid");
    });
  });

  // ========== PASSWORD VALIDATION ==========

  function validatePasswordForm() {
    let valid = true;
    clearErrors(passForm);

    const currentPassword = document.getElementById("currentPassword").value.trim();
    const newPassword = document.getElementById("newPassword").value.trim();
    const confirmPassword = document.getElementById("confirmPassword").value.trim();

    if (!currentPassword) {
      showError("currentPassword", "Current password is required.");
      valid = false;
    } else if (currentPassword.length < 8) {
      showError("currentPassword", "Invalid current password.");
      valid = false;
    } else {
      showValid("currentPassword");
    }

    if (!newPassword) {
      showError("newPassword", "New password is required.");
      valid = false;
    } else if (newPassword.length < 8) {
      showError("newPassword", "New password must be at least 8 characters.");
      valid = false;
    } else {
      showValid("newPassword");
    }

    if (confirmPassword.length < 8) {
      showError("confirmPassword", "Password confirmation is required.");
      valid = false;
    } else if (newPassword !== confirmPassword) {
      showError("confirmPassword", "Passwords do not match.");
      valid = false;
    } else {
      showValid("confirmPassword");
    }

    return valid;
  }

  // ========== HELPERS ==========

  function showError(field, message) {
    const input = document.getElementById(field);
    const error = document.getElementById(field + "Error");
    input?.classList.add("is-invalid");
    if (error) error.textContent = message;
  }

  function showValid(field) {
    const input = document.getElementById(field);
    const error = document.getElementById(field + "Error");
    input?.classList.remove("is-invalid");
    input?.classList.add("is-valid");
    if (error) error.textContent = "";
  }

  function clearErrors(form) {
    if (!form) return;
    form.querySelectorAll("input").forEach(input => {
      input.classList.remove("is-invalid", "is-valid");
    });
    form.querySelectorAll(".text-danger").forEach(el => el.textContent = "");
  }

  function clearFormFields(form) {
    if (!form) return;
    form.querySelectorAll("input").forEach(input => {
      input.value = '';
    });
  }

});
