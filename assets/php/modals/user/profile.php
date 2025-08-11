<!-- Update Profile Picture Modal -->
<div class="modal fade" id="updateProfilePictureModal" tabindex="-1" aria-labelledby="updateProfileModalLabel"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <div
                style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                <h4 class="modal-title text-center subheading" id="updateProfileModalLabel">UPDATE PROFILE PICTURE</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                    style="position: absolute; top: 16px; right: 16px;"></button>
            </div>
            <form method="POST" id="profileForm" enctype="multipart/form-data" novalidate>
                <div class="modal-body">
                    <div class="d-flex flex-column align-items-center gap-3">
                        <div class="rounded-circle overflow-hidden bg-black" style="width: 120px; height: 120px;">
                            <img id="profilePreview2" src="../assets/img/profile/<?php echo $pfpFileName ?>"
                                alt="Current Photo" class="w-100 h-100" style="object-fit: cover;">
                        </div>
                        <div class="d-flex align-items-center justify-content-center"
                            style="max-width: 350px; width: 100%;">
                            <input type="text" id="fileNameDisplay"
                                class="form-control text-black bg-transparent rounded-0 rounded-start" readonly>
                            <label class="btn btn-primary rounded-0 rounded-end d-inline-flex align-items-center"
                                for="fileInput">Browse <i class="bi bi-upload ms-2"></i></label>
                            <input type="file" class="d-none" id="fileInput" accept="image/*" name="profilePic">
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" name="btnSaveProfile" class="btn btn-primary">SAVE CHANGES</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Confirm Profile Pic Updated -->
<div class="modal fade" id="confirmUpdateProfilePicModal" tabindex="-1" aria-labelledby="confirmUpdateProfilePicLabel"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
            <div class="modal-header" style="border: none;">
                <h4 class="modal-title heading text-center w-100 text-black" id="confirmUpdateProfilePicModalLabel"
                    style="margin: 0;">
                    PROFILE PICTURE UPDATED
                </h4>
            </div>
            <div class="modal-body text-center text-black">
                Your profile picture has been successfully updated.
            </div>
            <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<!-- Remove Profile Picture Modal -->
<form method="POST">
    <div class="modal fade" id="removeProfilePictureModal" tabindex="-1"
        aria-labelledby="removeProfilePictureModalLabel" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px;">
                <!-- Header with top border radius -->
                <div style="background-color: var(--primaryColor); color: white; padding: 1rem;
                    border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                    <h4 class="modal-title text-center subheading" id="removeProfilePictureModalLabel">REMOVE PROFILE
                        PICTURE</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                        style="position: absolute; top: 16px; right: 16px;"></button>
                </div>
                <div class="modal-body text-center">
                    <p>
                        <span style="color: #D2042D;">Are you sure you want to remove your profile
                            picture?</span><br><br>
                        If yes, your profile will be set to our default picture.
                    </p>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" name="btnRemovePic" class="btn btn-primary">REMOVE</button>
                </div>
            </div>
        </div>
    </div>
</form>


<!-- Confirm Remove Profile Pic-->
<div class="modal fade" id="confirmRemoveProfilePictureModal" tabindex="-1"
    aria-labelledby="confirmRemoveProfilePictureModalLabel" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
            <div class="modal-header" style="border: none;">
                <h4 class="modal-title heading text-center w-100 text-black" id="confirmRemoveProfilePictureModalLabel"
                    style="margin: 0;">
                    PROFILE PICTURE REMOVED
                </h4>
            </div>
            <div class="modal-body text-center text-black">
                Your profile picture has been set to the default.
            </div>
            <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                <button type="button" name="btnClosePic" class="btn btn-primary" data-bs-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>


<!-- Edit Profile Info Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" id="editProfileForm">
            <div class="modal-content" style="border-radius: 15px;">
                <div
                    style="background-color: var(--primaryColor); color: white; padding: 1rem; border-radius: 15px 15px 0 0; position: relative;">
                    <h4 class="modal-title text-center subheading" id="editProfileModalLabel">EDIT PROFILE</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                        style="position: absolute; top: 16px; right: 16px;"></button>
                </div>
                <div class="modal-body" style="padding: 1.5rem;">
                    <div class="row">
                        <div class="col-md-6 mb-3 text-start">
                            <label for="firstName" class="form-label fw-bold">First Name</label>
                            <input type="text" class="form-control" name="firstName" id="firstName"
                                value="<?php echo $userInfoArray['firstName'] ?? ''; ?>">
                            <span id="firstNameError" class="text-danger d-block small m-1"></span>
                        </div>
                        <div class="col-md-6 mb-3 text-start">
                            <label for="lastName" class="form-label fw-bold">Last Name</label>
                            <input type="text" class="form-control" name="lastName" id="lastName"
                                value="<?php echo $userInfoArray['lastName'] ?? ''; ?>">
                            <span id="lastNameError" class="text-danger d-block small m-1"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 text-start">
                            <label for="Age" class="form-label fw-bold">Age</label>
                            <span data-bs-toggle="tooltip" data-bs-trigger="click"
                                title="Age is auto-calculated based on birthday." style="cursor: pointer;">
                                <i class="bi bi-info-circle text-secondary"></i>
                            </span>
                            <input type="text" class="form-control" name="age" id="Age"
                                value="<?php echo $userInfoArray['age']; ?>" disabled>
                        </div>
                    </div>
                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                            tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                                new bootstrap.Tooltip(tooltipTriggerEl);
                            });
                        });
                    </script>
                </div>
                <div class="modal-footer d-flex justify-content-end">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" name="btnSaveInfo" class="btn btn-primary">SAVE CHANGES</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Confirm Edit Profile Info Modal -->
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


<!-- RFID Modal -->
<div class="modal fade" id="rfidModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content position-relative">
            <div class="modal-body p-0">
                <img src="../assets/img/profile/rfidcard.png" alt="RFID Full" class="img-fluid rounded-4">
            </div>
            <span class="position-absolute"
                style="bottom: 10px; right: 10px; color: black; padding: 2px 6px; font-size: 20px;">
                <?php echo $userInfoArray['rfidNumber'] ?? 'N/A'; ?>
            </span>
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
                    <button type="submit" name="btnEmail" id="" class="btn btn-primary" style="margin-left: 0.5rem;">
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
                    <button type="submit" name="btnConfirmPass" id="" class="btn btn-primary"
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
                <input type="hidden" name="btnSaveAccInfo" value="1"> <!-- Correct trigger -->

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
                    <span style="color: #D2042D;">Are you sure you want to delete your account?</span><br><br>
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