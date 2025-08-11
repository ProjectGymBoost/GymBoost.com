<!-- Delete Modal -->
<?php foreach ($userInfoArray as $info): ?>
    <div class="modal fade" id="deleteUserModal<?php echo $info['userID']; ?>" tabindex="-1"
        aria-labelledby=" deleteUserModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px;">
                <!-- Header -->
                <div
                    style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                    <h4 class="modal-title text-center subheading" id="deleteUserModalLabel"
                        style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                        DELETE USER ACCOUNT
                    </h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                        style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;"></button>
                </div>

                <!-- Body -->
                <div class="modal-body text-center text-black" style="padding: 1.5rem;">
                    <p style="margin: 0; font-size: 16px;">
                        <span style="color: #D2042D;">
                            Are you sure you want to delete
                            <strong><?= htmlspecialchars($info['firstName'] . ' ' . $info['lastName']) ?>'s</strong>
                            account?
                        </span>
                        <br><br>
                        If you decided to delete this user's account, all data related to it will also be deleted.
                    </p>
                </div>

                <!-- Footer -->
                <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        CANCEL
                    </button>
                    <!-- Delete-BE Functionality-->
                    <form method="post">
                        <input type="hidden" name="deleteUserId" value="<?php echo $info['userID']; ?>">
                        <input type="hidden" name="deleteFirstName" value="<?php echo $info['firstName']; ?>">
                        <input type="hidden" name="deleteLastName" value="<?php echo $info['lastName']; ?>">
                        <button type="submit" class="btn btn-primary" name="btnDelete" style="margin-left: 0.5rem;">
                            DELETE
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Delete Confirmation Modal -->
<?php if (isset($_GET['deleted']) && $_GET['deleted'] == '1' && isset($_GET['name'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var confirmModal = new bootstrap.Modal(document.getElementById('confirmDeleteUserModal'));
            confirmModal.show();

            const url = new URL(window.location);
            url.searchParams.delete('deleted');
            url.searchParams.delete('name');
            history.replaceState(null, '', url.toString());
        });
    </script>
<?php endif; ?>

<div class="modal fade" id="confirmDeleteUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header border-0">
                <h4 class="modal-title heading text-center w-100 text-black">USER DELETED</h4>
            </div>
            <div class="modal-body text-center">
                <strong>
                    <span style="color: #D2042D; font-weight: bold;">
                        <?php echo $_GET['name'] . "'s"; ?>
                    </span>
                </strong>
                account has been successfully deleted.
            </div>
            <div class="modal-footer d-flex justify-content-center pb-4 border-0">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>