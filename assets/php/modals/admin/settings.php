<!-- Edit Profile Info Modal -->
<div class="modal fade" id="editNameModal" tabindex="-1" aria-labelledby="editNameModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" id="editNameForm">
            <div class="modal-content" style="border-radius: 15px;">
                <div
                    style="background-color: var(--primaryColor); color: white; padding: 1rem; border-radius: 15px 15px 0 0; position: relative;">
                    <h4 class="modal-title text-center subheading" id="editNameModalLabel">EDIT NAME</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                        style="position: absolute; top: 16px; right: 16px;"></button>
                </div>
                <div class="modal-body" style="padding: 1.5rem;">
                    <div class="row">
                        <div class="col-md-6 mb-3 text-start">
                            <label for="firstName" class="form-label fw-bold">First Name</label>
                            <input type="text" class="form-control" name="firstName" id="firstName"
                                value="<?php echo htmlspecialchars($userInfoArray['firstName'] ?? ''); ?>">
                            <span id="firstNameError" class="text-danger small d-block mt-1"></span>
                        </div>
                        <div class="col-md-6 mb-3 text-start">
                            <label for="lastName" class="form-label fw-bold">Last Name</label>
                            <input type="text" class="form-control" name="lastName" id="lastName"
                                value="<?php echo htmlspecialchars($userInfoArray['lastName'] ?? ''); ?>">
                            <span id="lastNameError" class="text-danger small d-block mt-1"></span>
                        </div>

                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" name="btnSaveInfo" class="btn btn-primary">SAVE CHANGES</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Confirm Edit Admin Info Modal -->
<div class="modal fade" id="confirmNameModal" tabindex="-1" aria-labelledby="confirmNameModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
            <div class="modal-header" style="border: none;">
                <h4 class="modal-title heading text-center w-100 text-black" id="confirmNameModalLabel"
                    style="margin: 0;">
                    NAME UPDATED
                </h4>
            </div>
            <div class="modal-body text-center text-black">
                Your name has been successfully edited.
            </div>
            <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                <button type="button" id="btnCloseSubmit" class="btn btn-primary" data-bs-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>


<!-- Confirm Edit Admin Info Modal -->
<div class="modal fade" id="confirmEditProfileModal" tabindex="-1" aria-labelledby="confirmEditProfileModalLabel"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
            <div class="modal-header" style="border: none;">
                <h4 class="modal-title heading text-center w-100 text-black" id="confirmEditProfileModalLabel"
                    style="margin: 0;">
                    PROFILE UPDATED
                </h4>
            </div>
            <div class="modal-body text-center text-black">
                Your profile has been successfully edited.
            </div>
            <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                <button type="button" id="btnCloseSubmit" class="btn btn-primary" data-bs-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Account Email Modal -->
<?php if (isset($_SESSION['show_modal'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modalId = "<?= $_SESSION['show_modal']; ?>";
            const targetModal = new bootstrap.Modal(document.getElementById(modalId));
            targetModal.show();
        });
    </script>
    <?php
    unset($_SESSION['show_modal']);
endif; ?>


<div class="modal fade" id="editAccountEmailModal" tabindex="-1" aria-labelledby="editAccountEmailModalLabel"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <input type="hidden" name="btnSaveAccInfo" value="1">
        <div class="modal-content" style="border-radius: 15px;">
            <form id="" method="POST">

                <!-- Header -->
                <div
                    style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                    <h4 class="modal-title text-center subheading" id="editAccountInfoModalLabel"
                        style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                        EDIT EMAIL
                    </h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                        style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;">
                    </button>
                </div>

                <!-- Body -->
                <div class="modal-body" style="padding: 1.5rem;">

                    <div class="mb-3 text-start">
                        <label for="email" class="form-label fw-bold">Current Email</label>
                        <input type="text" class="form-control"
                            value="<?= htmlspecialchars($userInfoArray['email'] ?? '') ?>" disabled>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="email" class="form-label fw-bold">New Email</label>
                        <?php
                        $emailInputValue = isset($_SESSION['oldEmailInput'])
                            ? $_SESSION['oldEmailInput']
                            : ($userInfoArray['email'] ?? '');
                        ?>
                        <input type="text" class="form-control" name="verifyEmail" placeholder="Enter new email..."
                            id="email">
                        <span id="emailError" class="text-danger small d-block mt-1">
                            <?= $_SESSION['emailInputError'] ?? '' ?>
                        </span>
                        <?php unset($_SESSION['emailInputError']); ?>

                    </div>

                </div>

                <!-- Footer -->
                <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        CANCEL
                    </button>
                    <button type="submit" name="btnAdminEmail" id="" class="btn btn-primary" style="margin-left: 0.5rem;">
                        SAVE CHANGES
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- OTP Modal -->
<div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <form id="" method="POST">
                <!-- Header -->
                <div
                    style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                    <h4 class="modal-title text-center subheading" id="editAccountInfoModalLabel"
                        style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                        EMAIL VERIFICATION
                    </h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                        style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;">
                    </button>
                </div>

                <!-- Body -->
                <div class="modal-body" style="padding: 1.5rem;">
                    <div class="mb-3 text-start">
                        <label for="otp" class="form-label fw-bold">Enter OTP sent to your new email.</label>
                        <input type="number" class="form-control" placeholder="Enter OTP..." name="enteredOTP" id="otp">
                        <span id="otpError" class="invalid-feedback small d-block mt-1">
                            <?= $_SESSION['otpError'] ?? '' ?>
                        </span>
                        <?php unset($_SESSION['otpError']); ?>

                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        CANCEL
                    </button>
                    <button type="submit" name="btnAdminConfirmPass" id="" class="btn btn-primary"
                        style="margin-left: 0.5rem;">
                        SAVE CHANGES
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Confirm Edit Email Modal -->
<div class="modal fade" id="confirmEditEmailInfoModal" tabindex="-1" aria-labelledby="confirmEditEmailInfoModalLabel"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
            <div class="modal-header" style="border: none;">
                <h4 class="modal-title heading text-center w-100 text-black" id="confirmEditAccountInfoModalLabel"
                    style="margin: 0;">
                    EMAIL UPDATED
                </h4>
            </div>
            <div class="modal-body text-center text-black">
                Your email has been successfully updated.
            </div>
            <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Account Password Modal -->
<div class="modal fade" id="editAccountPassModal" tabindex="-1" aria-labelledby="editAccountPassModalLabel"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <form id="editAccountPassForm" method="POST">
                <input type="hidden" name="btnSaveAccInfo" value="1">

                <!-- Modal Header -->
                <div
                    style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <h4 class="modal-title text-center subheading" id="editAccountPassModalLabel"
                        style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                        EDIT PASSWORD
                    </h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                        style="position: absolute; top: 16px; right: 16px;"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body" style="padding: 1.5rem;">
                    <?php if (isset($_SESSION['currentPasswordError'])): ?>
                        <input type="hidden" id="currentPasswordErrorValue"
                            value="<?= htmlspecialchars($_SESSION['currentPasswordError']); ?>">
                        <?php unset($_SESSION['currentPasswordError']); ?>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['accountUpdated'])): ?>
                        <input type="hidden" id="accountUpdatedFlag" value="true">
                        <?php unset($_SESSION['accountUpdated']); ?>
                    <?php endif; ?>

                    <div class="mb-3 text-start">
                        <label for="currentPassword" class="form-label fw-bold">Current Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="currentPass" id="currentPassword"
                                placeholder="Enter your current password"
                                value="<?= htmlspecialchars($_POST['currentPass'] ?? ($_SESSION['currentPass'] ?? '')) ?>">
                            <span class="input-group-text toggle-password" data-target="currentPassword"
                                style="cursor: pointer;">
                                <i class="bi bi-eye-slash"></i>
                            </span>
                        </div>
                        <span id="currentPasswordError" class="text-danger small d-block mt-1"></span>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="newPassword" class="form-label fw-bold">New Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="newPass" id="newPassword"
                                placeholder="Enter a new password"
                                value="<?= htmlspecialchars($_POST['newPass'] ?? ($_SESSION['newPass'] ?? '')) ?>">
                            <span class="input-group-text toggle-password" data-target="newPassword"
                                style="cursor: pointer;">
                                <i class="bi bi-eye-slash"></i>
                            </span>
                        </div>
                        <span id="newPasswordError" class="text-danger small d-block mt-1"></span>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="confirmPassword" class="form-label fw-bold">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="confirmPass" id="confirmPassword"
                                placeholder="Confirm your password"
                                value="<?= htmlspecialchars($_POST['confirmPass'] ?? ($_SESSION['confirmPass'] ?? '')) ?>">
                            <span class="input-group-text toggle-password" data-target="confirmPassword"
                                style="cursor: pointer;">
                                <i class="bi bi-eye-slash"></i>
                            </span>
                        </div>
                        <span id="confirmPasswordError" class="text-danger small d-block mt-1"></span>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" id="saveAccountChangesBtn" class="btn btn-primary">
                        SAVE CHANGES
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Confirm Edit Password Modal -->
<div class="modal fade" id="confirmEditPassModal" tabindex="-1" aria-labelledby="confirmEditPassModalLabel"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
            <div class="modal-header" style="border: none;">
                <h4 class="modal-title heading text-center w-100 text-black" id="confirmEditPassModalLabel"
                    style="margin: 0;">
                    PASSWORD UPDATED
                </h4>
            </div>
            <div class="modal-body text-center text-black">
                Your account password has been successfully updated.
            </div>
            <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>


<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <!-- Header -->
            <div
                style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                <h4 class="modal-title text-center subheading" id="deleteAccountModalLabel">DELETE ACCOUNT</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                    style="position: absolute; top: 16px; right: 16px;"></button>
            </div>
            <!-- Body -->
            <div class="modal-body text-center text-black" style="padding: 1.5rem;">
                <p>
                    <span style="color: #D2042D;">Are you sure you want to delete this admin account?</span><br><br>
                    If you proceed, all associated data will be permanently removed.
                </p>
            </div>
            <!-- Footer -->
            <div class="modal-footer justify-content-end" style="padding: 1rem;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#confirmdeleteAccountModal" data-bs-dismiss="modal">DELETE</button>
            </div>
        </div>
    </div>
</div>

<!-- Confirm Delete Account Modal -->
<div class="modal fade" id="confirmdeleteAccountModal" tabindex="-1" aria-labelledby="confirmDeleteAccountModalLabel"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
            <form method="POST">
                <div class="modal-header" style="border: none;">
                    <h4 class="modal-title heading text-center w-100 text-black" id="confirmDeleteAccountModalLabel"
                        style="margin: 0;">
                        ACCOUNT DELETED
                    </h4>
                </div>
                <div class="modal-body text-center text-black">
                    This account has been successfully deleted.<br>
                    You will be logged out and will be redirected to the login page.
                </div>
                <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                    <button type="submit" id="btnCloseDelete" name="btnCloseDelete" class="btn btn-primary"
                        data-bs-dismiss="modal">CLOSE</button>
                </div>
            </form>
        </div>
    </div>
</div>