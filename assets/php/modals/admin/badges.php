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
                        ['badgeName', 'Badge Name', 'text'],
                        ['description', 'Description', 'text'],
                        ['requirementValue', 'Requirement Value', 'number'],
                    ];
                    foreach ($fields as [$name, $label, $type]):
                        $extraAttributes = ($name === 'requirementValue') ? 'min="0" step="1" oninput="this.value = this.value.replace(/[^0-9]/g, \'\')"' : '';
                        ?>
                        <div class="mb-3 text-start">
                            <label for="<?= $name ?>" class="form-label fw-bold"><?= $label ?></label>
                            <input type="<?= $type ?>" class="form-control" id="<?= $name ?>" name="<?= $name ?>" required
                                <?= $extraAttributes ?>>
                        </div>
                    <?php endforeach; ?>

                    <div class="mb-3 text-start">
                        <label for="badgeIcon" class="form-label fw-bold">Icon</label>
                        <input type="file" class="form-control" id="badgeIcon" name="iconUrl" accept="image/*" required>
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

<!--(BADGES) EDIT -->
<?php foreach ($badgeInfoArray as $info): ?>
    <?php $badgeID = htmlspecialchars($info['badgeID']); ?>
    <div class="modal fade" id="editBadgeModal<?= $badgeID ?>" tabindex="-1"
        aria-labelledby="editBadgeModalLabel<?= $badgeID ?>" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
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
                <form id="editBadgeForm<?= $badgeID ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-body p-4">
                        <input type="hidden" name="badgeID" value="<?= $badgeID ?>">
                        <input type="hidden" name="iconUrl" value="<?= htmlspecialchars($info['iconUrl']) ?>">

                        <?php
                        $fields = [
                            ['badgeName', 'Badge', $info['badgeName']],
                            ['description', 'Description', $info['description']],
                            ['requirementValue', 'Requirement Value', $info['requirementValue']],
                        ];
                        foreach ($fields as [$name, $label, $value]):
                            $inputType = ($name === 'requirementValue') ? 'number' : 'text';
                            $extraAttributes = ($inputType === 'number') ? 'min="0" step="1" oninput="this.value = this.value.replace(/[^0-9]/g, \'\')"' : '';
                            ?>
                            <div class="mb-3">
                                <label for="<?= $name . $badgeID ?>" class="form-label fw-bold"><?= $label ?></label>
                                <input type="<?= $inputType ?>" class="form-control" id="<?= $name . $badgeID ?>"
                                    name="<?= $name ?>" value="<?= htmlspecialchars($value) ?>" <?= $extraAttributes ?>>
                            </div>
                        <?php endforeach; ?>

                        <div class="mb-3">
                            <label for="badgeIcon<?= $badgeID ?>" class="form-label fw-bold">Icon</label>
                            <input type="file" class="form-control" id="badgeIcon<?= $badgeID ?>" name="iconUrl"
                                accept="image/*">
                            <?php if (!empty($info['iconUrl'])): ?>
                                <div class="mt-2 text-muted small">
                                    Current icon URL: <code><?= htmlspecialchars($info['iconUrl']) ?></code>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer border-0 justify-content-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn btn-primary ms-2" name="btnEdit">SAVE CHANGES</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

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