<!--(BADGES) ADD -->
<div class="modal fade" id="addBadgeModal" tabindex="-1" aria-labelledby="addBadgeModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <!-- Header -->
            <div
                style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                <h4 class="modal-title text-center subheading" id="addBadgeModalLabel"
                    style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                    ADD NEW BADGE
                </h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                    style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;">
                </button>
            </div>

            <!-- Body -->
            <form id="addBadgeForm" method="POST" enctype="multipart/form-data">
                <div class="modal-body" style="padding: 1.5rem;">
                    <?php
                    $fields = [
                        ['badgeName', 'Badge Name', 'text', isset($badgeNameError) ? $badgeNameError : ''],
                        ['description', 'Description', 'text', isset($descriptionError) ? $descriptionError : ''],
                        ['requirementValue', 'Requirement Value', 'number', isset($requirementValueError) ? $requirementValueError : ''],
                    ];

                    foreach ($fields as [$name, $label, $type, $error]) {
                        $extraAttributes = ($name === 'requirementValue') ? 'min="0" step="1" oninput="this.value = this.value.replace(/[^0-9]/g, \'\')"' : '';
                        $value = (isset($_POST['btnAdd']) && isset($_POST[$name])) ? htmlspecialchars($_POST[$name]) : '';
                        ?>
                        <div class="mb-3 text-start">
                            <label for="<?= $name ?>" class="form-label fw-bold"><?= $label ?></label>
                            <input type="<?= $type ?>" class="form-control" id="<?= $name ?>" name="<?= $name ?>"
                                value="<?= $value ?>" required <?= $extraAttributes ?>>
                            <?php if (!empty($error)): ?>
                                <div class="text-danger mt-1" style="font-size: 0.875rem;"><?= $error ?></div>
                            <?php endif; ?>
                        </div>
                    <?php } ?>

                    <div class="mb-3 text-start">
                        <label for="badgeIcon" class="form-label fw-bold">Icon</label>
                        <input type="file" class="form-control" id="badgeIcon" name="iconUrl" accept="image/*" required>
                        <?php if (!empty($iconUrlError)): ?>
                            <div class="text-danger mt-1" style="font-size: 0.875rem;"><?= $iconUrlError ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn btn-primary" name="btnAdd">ADD</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Trigger modal open if any error message is set
$showAddModal = false;
if (
    isset($_POST['btnAdd']) && (
        !empty($badgeNameError) ||
        !empty($descriptionError) ||
        !empty($requirementValueError) ||
        !empty($iconUrlError)
    )
) {
    $showAddModal = true;
}

?>

<?php if ($showAddModal): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var addModal = new bootstrap.Modal(document.getElementById('addBadgeModal'));
            addModal.show();

            // Prevent form resubmission
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        });
    </script>
<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addBadgeForm = document.getElementById('addBadgeForm');
        const modal = document.getElementById('addBadgeModal');

        // Reset form and clear errors when modal is closed
        modal.addEventListener('hidden.bs.modal', function () {
            addBadgeForm.reset();
            document.querySelectorAll('#addBadgeModal .text-danger').forEach(el => el.textContent = '');
        });
    });
</script>

<!--(BADGES) EDIT -->
<?php foreach ($badgeInfoArray as $info): ?>
    <?php
    $badgeID = htmlspecialchars($info['badgeID']);
    $badgeName = htmlspecialchars($info['badgeName']);
    $description = htmlspecialchars($info['description']);
    $requirementValue = htmlspecialchars($info['requirementValue']);
    $iconUrl = htmlspecialchars($info['iconUrl']);

    // Set error variables safely
    $badgeNameError = isset(${"badgeNameError_$badgeID"}) ? ${"badgeNameError_$badgeID"} : '';
    $descriptionError = isset(${"descriptionError_$badgeID"}) ? ${"descriptionError_$badgeID"} : '';
    $requirementValueError = isset(${"requirementValueError_$badgeID"}) ? ${"requirementValueError_$badgeID"} : '';
    $iconUrlError = isset(${"iconUrlError_$badgeID"}) ? ${"iconUrlError_$badgeID"} : '';

    // Check if this is the badge being edited
    $isEditingThisBadge = isset($_POST['btnEdit']) && isset($_POST['badgeID']) && $_POST['badgeID'] == $badgeID;
    ?>

    <div class="modal fade" id="editBadgeModal<?= $badgeID ?>" tabindex="-1"
        aria-labelledby="editBadgeModalLabel<?= $badgeID ?>" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">

                    <!-- Header -->
                    <div
                        style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                        <h4 class="modal-title text-center subheading" id="editBadgeModalLabel<?= $badgeID ?>"
                            style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                            EDIT BADGES
                        </h4>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                            style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;">
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body p-4">
                        <input type="hidden" name="badgeID" value="<?= $badgeID ?>">
                        <input type="hidden" name="originalIconUrl" value="<?= htmlspecialchars($iconUrl) ?>">

                        <!-- Badge Name -->
                        <div class="mb-3">
                            <label for="badgeName<?= $badgeID ?>" class="form-label fw-bold">Badge Name</label>
                            <input type="text" class="form-control" id="badgeName<?= $badgeID ?>" name="badgeName"
                                value="<?= $isEditingThisBadge && isset($_POST['badgeName']) ? htmlspecialchars($_POST['badgeName']) : $badgeName ?>"
                                required>
                            <?php if (!empty($badgeNameError)): ?>
                                <div class="text-danger small mt-1"><?= $badgeNameError ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description<?= $badgeID ?>" class="form-label fw-bold">Description</label>
                            <textarea class="form-control" id="description<?= $badgeID ?>" name="description" rows="3"
                                required><?= $isEditingThisBadge && isset($_POST['description']) ? htmlspecialchars($_POST['description']) : $description ?></textarea>
                            <?php if (!empty($descriptionError)): ?>
                                <div class="text-danger small mt-1"><?= $descriptionError ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Requirement Value -->
                        <div class="mb-3">
                            <label for="requirementValue<?= $badgeID ?>" class="form-label fw-bold">Requirement
                                Value</label>
                            <input type="number" class="form-control" id="requirementValue<?= $badgeID ?>"
                                name="requirementValue"
                                value="<?= $isEditingThisBadge && isset($_POST['requirementValue']) ? htmlspecialchars($_POST['requirementValue']) : $requirementValue ?>"
                                required>
                            <?php if (!empty($requirementValueError)): ?>
                                <div class="text-danger small mt-1"><?= $requirementValueError ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Icon -->
                        <div class="mb-3">
                            <label for="iconUrl<?= $badgeID ?>" class="form-label fw-bold">Icon</label>
                            <input type="file" class="form-control" id="iconUrl<?= $badgeID ?>" name="iconUrl"
                                accept=".png,.jpg,.jpeg" <?= empty($iconUrl) ? 'required' : '' ?>>
                            <?php if (!empty($iconUrlError)): ?>
                                <div class="text-danger small mt-1"><?= $iconUrlError ?></div>
                            <?php endif; ?>
                            <?php if (!empty($iconUrl)): ?>
                                <div class="mt-2 text-muted small">
                                    Current icon URL: <?= htmlspecialchars($iconUrl) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer border-0 justify-content-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" name="btnEdit" class="btn btn-primary ms-2">SAVE CHANGES</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php if (isset($_POST['btnEdit']) && isset($hasError) && $hasError && isset($_POST['badgeID'])): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var editModal = new bootstrap.Modal(document.getElementById("editBadgeModal<?= $_POST['badgeID'] ?>"));
            editModal.show();

            // Prevent form resubmission
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        });
    </script>
<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Select all edit modals
        document.querySelectorAll('[id^="editBadgeModal"]').forEach(function (modalEl) {
            const form = modalEl.querySelector('form');

            // Reset form and clear errors when the modal is closed
            modalEl.addEventListener('hidden.bs.modal', function () {
                if (form) {
                    form.reset();
                }
                modalEl.querySelectorAll('.text-danger').forEach(el => el.textContent = '');
            });
        });
    });
</script>

<!--(BADGES) DELETE -->
<?php foreach ($badgeInfoArray as $info): ?>
    <div class="modal fade" id="deleteBadgeModal<?php echo $info['badgeID']; ?>" tabindex="-1"
        aria-labelledby=" deleteBadgeModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px;">
                <!-- Header -->
                <div
                    style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                    <h4 class="modal-title text-center subheading" id="deleteBadgeModalLabel"
                        style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                        DELETE BADGE
                    </h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                        style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;"></button>
                </div>

                <!-- Body -->
                <div class="modal-body text-center text-black" style="padding: 1.5rem;">
                    <p style="margin: 0; font-size: 16px;">
                        <span style="color: #D2042D;">
                            Are you sure you want to delete this
                            <strong><?= htmlspecialchars($info['badgeName']) ?></strong>
                            badge?
                        </span>
                        <br><br>
                        Once deleted, this badge will be permanently removed from the system and cannot be restored.
                    </p>
                </div>

                <!-- Footer -->
                <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        CANCEL
                    </button>
                    <!-- Delete-BE Functionality-->
                    <form method="post">
                        <input type="hidden" name="deleteBadgeId" value="<?php echo $info['badgeID']; ?>">
                        <input type="hidden" name="deleteBadgeName" value="<?php echo $info['badgeName']; ?>">
                        <button type="submit" class="btn btn-primary" name="btnDelete" style="margin-left: 0.5rem;">
                            DELETE
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- (BADGES) Confirmation Modals-->
<script>
    function showModalAndCleanURL(modalId, paramsToRemove) {
        window.addEventListener('DOMContentLoaded', function () {
            const modalElement = document.getElementById(modalId);
            if (modalElement) {
                const modal = new bootstrap.Modal(modalElement);
                modal.show();

                const url = new URL(window.location);
                paramsToRemove.forEach(param => url.searchParams.delete(param));
                if (url.hash === '#userBadgeSection') {
                    url.hash = '';
                }
                history.replaceState(null, '', url.toString());
            } else {
                console.warn("Modal with ID '" + modalId + "' not found.");
            }
        });
    }
</script>

<!--(BADGES) ADD Confirmation -->
<?php if (isset($_GET['added']) && $_GET['added'] == '1' && isset($_GET['addBadgeId'])): ?>
    <script>
        showModalAndCleanURL('confirmAddBadgeModal', ['added', 'addBadgeId']);
    </script>
<?php endif; ?>

<div class="modal fade" id="confirmAddBadgeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header border-0">
                <h4 class="modal-title heading text-center w-100 text-black">BADGE ADDED</h4>
            </div>
            <div class="modal-body text-center text-black">
                Badge has been successfully added.
            </div>
            <div class="modal-footer d-flex justify-content-center pb-4 border-0">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<!--(BADGES) EDIT Confirmation-->
<?php if (isset($_GET['edited']) && $_GET['edited'] == '1' && isset($_GET['editBadgeId'])): ?>
    <script>
        showModalAndCleanURL('confirmEditBadgeModal', ['edited', 'editBadgeId']);
    </script>
<?php endif; ?>

<div class="modal fade" id="confirmEditBadgeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header border-0">
                <h4 class="modal-title heading text-center w-100 text-black">BADGE UPDATED</h4>
            </div>
            <div class="modal-body text-center text-black">
                Badge has been successfully edited.
            </div>
            <div class="modal-footer d-flex justify-content-center pb-4 border-0">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<!--(BADGES) DELETE Confirmation-->
<?php if (isset($_GET['deleted']) && $_GET['deleted'] == '1' && isset($_GET['deleteBadgeId'])): ?>
    <script>
        showModalAndCleanURL('confirmDeleteBadgeModal', ['deleted', 'deleteBadgeId']);
    </script>
<?php endif; ?>

<div class="modal fade" id="confirmDeleteBadgeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header border-0">
                <h4 class="modal-title heading text-center w-100 text-black">BADGE DELETED</h4>
            </div>
            <div class="modal-body text-center">
                Badge has been successfully deleted.
            </div>
            <div class="modal-footer d-flex justify-content-center pb-4 border-0">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>


<!-- (USER-BADGES) DELETE -->
<?php foreach ($userBadgeInfoArray as $infoAlt): ?>
    <div class="modal fade" id="deleteUserBadgeModal<?php echo $infoAlt['userBadgeID']; ?>" tabindex="-1"
        aria-labelledby=" deleteUserBadgeModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px;">
                <!-- Header -->
                <div
                    style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                    <h4 class="modal-title text-center subheading" id="deleteUserBadgeModalLabel"
                        style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                        DELETE USER BADGE
                    </h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                        style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;"></button>
                </div>

                <!-- Body -->
                <div class="modal-body text-center text-black" style="padding: 1.5rem;">
                    <p style="margin: 0; font-size: 16px;">
                        <span style="color: #D2042D;">
                            Are you sure you want to delete
                            <strong><?= htmlspecialchars($infoAlt['username']) ?>'s</strong>
                            badge?
                        </span>
                        <br><br>
                        Once deleted, this user badge will be permanently removed from the system and cannot be restored.
                    </p>
                </div>

                <!-- Footer -->
                <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        CANCEL
                    </button>
                    <!-- Delete-BE Functionality-->
                    <form method="post">
                        <input type="hidden" name="deleteUserBadgeId" value="<?php echo $infoAlt['userBadgeID']; ?>">
                        <input type="hidden" name="deleteUsername" value="<?php echo $infoAlt['username']; ?>">
                        <button type="submit" class="btn btn-primary" name="btnDeleteAlt" style="margin-left: 0.5rem;">
                            DELETE
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!--(USER-BADGES) DELETE Confirmation-->
<?php if (isset($_GET['deleted']) && $_GET['deleted'] == '1' && isset($_GET['deleteUserBadgeId'])): ?>
    <script>
        showModalAndCleanURL('confirmDeleteUserBadgeModal', ['deleted', 'deleteUserBadgeId']);
    </script>
<?php endif; ?>

<div class="modal fade" id="confirmDeleteUserBadgeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header border-0">
                <h4 class="modal-title heading text-center w-100 text-black">USER BADGE DELETED</h4>
            </div>
            <div class="modal-body text-center">
                Badge has been successfully deleted.
            </div>
            <div class="modal-footer d-flex justify-content-center pb-4 border-0">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>