document.addEventListener("DOMContentLoaded", function () {

  // Profile info
  const profileUpdatedFlag = document.getElementById("profileUpdatedFlag")?.value;
  if (profileUpdatedFlag === "true") {
    const confirmProfileModalEl = document.getElementById("confirmEditProfileModal");
    const confirmProfileModal = bootstrap.Modal.getOrCreateInstance(confirmProfileModalEl);
    setTimeout(() => confirmProfileModal.show(), 300);
  }

  // Profile picture updated 
  const picUpdatedFlag = document.getElementById("profilePicUpdatedFlag")?.value;
  if (picUpdatedFlag === "true") {
    const confirmPicModalEl = document.getElementById("confirmUpdateProfilePicModal");
    const confirmPicModal = bootstrap.Modal.getOrCreateInstance(confirmPicModalEl);
    setTimeout(() => confirmPicModal.show(), 300);
  }

  // Remove pic
  const removedPicFlag = document.getElementById("profilePicRemovedFlag")?.value;
  if (removedPicFlag === "true") {
    const confirmRemoveModalEl = document.getElementById("confirmRemoveProfilePictureModal");
    if (confirmRemoveModalEl) {
      const confirmRemoveModal = bootstrap.Modal.getOrCreateInstance(confirmRemoveModalEl);
      setTimeout(() => confirmRemoveModal.show(), 300);
    }
  }

  // EDIT PROFILE MODAL
  const profileForm = document.getElementById("editProfileForm");
  const editProfileModalEl = document.getElementById("editProfileModal");
  const saveProfileChangesBtn = document.getElementById("saveChangesBtn");
  const editProfileModal = bootstrap.Modal.getOrCreateInstance(editProfileModalEl);

  let profileFormSaved = false;

  profileForm.addEventListener("submit", function (e) {
    const isValid = validateProfileForm();
    if (!isValid) {
      e.preventDefault();
      profileFormSaved = false;
      return;
    }

    profileFormSaved = true;
    editProfileModal.hide();
  });

  editProfileModalEl.addEventListener("hidden.bs.modal", function () {
    if (!profileFormSaved) {
      profileForm.reset();
      clearErrors(profileForm);
    }
    profileFormSaved = false;
  });

  function validateProfileForm() {
    let valid = true;
    clearErrors(profileForm);

  // Validation
    const firstName = document.getElementById("firstName").value.trim();
    const lastName = document.getElementById("lastName").value.trim();

    if (!/^[a-zA-Z-' ]+$/.test(firstName)) {
      showError("firstName", "Only letters and white space allowed.");
      valid = false;
    } else {
      showValid("firstName");
    }

    if (!/^[a-zA-Z-' ]+$/.test(lastName)) {
      showError("lastName", "Only letters and white space allowed.");
      valid = false;
    } else {
      showValid("lastName");
    }

    return valid;
  }

  // EDIT PASSWORD MODAL
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

  // Validation Logic 
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

  // Helpers
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
