<!-- Add Announcement Modal -->
<div class="modal fade" id="addAnnouncementModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <form method="POST">
                <div style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                    <h4 class="modal-title text-center subheading" style="margin: 0; font-size: 20px; letter-spacing: 2px;">ADD ANNOUNCEMENT</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                        style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;">
                    </button>
                </div>
                <div class="modal-body" style="padding: 1.5rem;">
                    <div class="mb-3 text-start">
                        <label for="newAnnouncementTitle" class="form-label fw-bold">Title</label>
                        <input type="text" class="form-control" placeholder="Enter title" name="newAnnouncementTitle" required>
                    </div>
                    <div class="text-start">
                        <label for="newAnnouncementMessage" class="form-label fw-bold">Message</label>
                        <textarea class="form-control" placeholder="Enter message" name="newAnnouncementMessage" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end" style="padding: 1rem;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" name="btnAddAnnouncement" class="btn btn-primary">ADD</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Confirm Add Modal -->
<?php if (isset($_GET['added']) && $_GET['added'] == 1): ?>
<script>
    window.addEventListener('DOMContentLoaded', function () {
        var modal = new bootstrap.Modal(document.getElementById('confirmAddAnnouncementModal'));
        modal.show();
    });
</script>
<div class="modal fade" id="confirmAddAnnouncementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; color: white;">
            <div class="modal-header" style="border: none;">
                <h4 class="modal-title heading text-center w-100 text-black" style="margin: 0;">ANNOUNCEMENT ADDED</h4>
            </div>
            <div class="modal-body text-center text-black">
                The new announcement has been successfully added.
            </div>
            <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php foreach ($announcementInfoArray as $a): ?>
<!-- Edit Announcement Modal -->
<div class="modal fade" id="editAnnouncement<?= $a['announcementID'] ?>Modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <form method="POST">
                <input type="hidden" name="editAnnouncementID" value="<?= $a['announcementID'] ?>">
                <div style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                    <h4 class="modal-title text-center subheading" style="margin: 0; font-size: 20px; letter-spacing: 2px;">EDIT ANNOUNCEMENT</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                        style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;">
                    </button>
                </div>
                <div class="modal-body" style="padding: 1.5rem;">
                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold">Title</label>
                        <input type="text" class="form-control" name="editAnnouncementTitle" value="<?= htmlspecialchars($a['title']) ?>" required>
                    </div>
                    <div class="text-start">
                        <label class="form-label fw-bold">Message</label>
                        <textarea class="form-control" name="editAnnouncementMessage" rows="3" required><?= htmlspecialchars($a['message']) ?></textarea>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end" style="padding: 1rem;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" name="btnEditAnnouncement" class="btn btn-primary">SAVE CHANGES</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Confirm Edit Modal -->
<?php if (isset($_GET['updated']) && $_GET['updated'] == 1 && isset($_GET['highlight']) && $_GET['highlight'] == $a['announcementID']): ?>
<script>
    window.addEventListener('DOMContentLoaded', function () {
        var modal = new bootstrap.Modal(document.getElementById('confirmEditAnnouncement<?= $a['announcementID'] ?>Modal'));
        modal.show();
    });
</script>
<div class="modal fade" id="confirmEditAnnouncement<?= $a['announcementID'] ?>Modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; color: white;">
            <div class="modal-header" style="border: none;">
                <h4 class="modal-title heading text-center w-100 text-black">ANNOUNCEMENT UPDATED</h4>
            </div>
            <div class="modal-body text-center text-black">
                The <strong><?= htmlspecialchars($a['title']) ?></strong> announcement has been successfully updated.
            </div>
            <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Delete Announcement Modal -->
<div class="modal fade" id="deleteAnnouncement<?= $a['announcementID'] ?>Modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <form method="POST">
                <input type="hidden" name="deleteAnnouncementID" value="<?= $a['announcementID'] ?>">
                <input type="hidden" name="page" value="<?= $currentPage ?>">
                <input type="hidden" name="entriesCount" value="<?= $entriesCount ?>">
                <div style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                    <h4 class="modal-title text-center subheading" style="margin: 0; font-size: 20px; letter-spacing: 2px;">DELETE ANNOUNCEMENT</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                        style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;">
                    </button>
                </div>
                <div class="modal-body text-center text-black" style="padding: 1.5rem;">
                    <p style="margin: 0; font-size: 16px;">
                        <span style="color: #D2042D;">Are you sure you want to delete this <strong><?= htmlspecialchars($a['title']) ?></strong> announcement?</span><br><br>
                        Once deleted, this announcement will no longer be visible to others and cannot be
                        recovered.
                    </p>
                </div>
                <div class="modal-footer d-flex justify-content-end" style="padding: 1rem;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" name="btnDeleteAnnouncement" class="btn btn-primary">DELETE</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Confirm Delete Modal -->
<?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1 && isset($_GET['highlight']) && $_GET['highlight'] == $a['announcementID']): ?>
<script>
    window.addEventListener('DOMContentLoaded', function () {
        var modal = new bootstrap.Modal(document.getElementById('confirmDeleteAnnouncement<?= $a['announcementID'] ?>Modal'));
        modal.show();
    });
</script>
<div class="modal fade" id="confirmDeleteAnnouncement<?= $a['announcementID'] ?>Modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; color: white;">
            <div class="modal-header" style="border: none;">
                <h4 class="modal-title heading text-center w-100 text-black">ANNOUNCEMENT DELETED</h4>
            </div>
            <div class="modal-body text-center text-black">
                The <strong><?= htmlspecialchars($a['title']) ?></strong> announcement has been successfully deleted.
            </div>
            <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php endforeach; ?>

<?php
if (isset($_GET['deleted']) && $_GET['deleted'] == '1' && isset($_GET['highlight'])):
    $deletedID = $_GET['highlight'];
    $deletedTitle = '';

    // Find the announcement title by ID
    foreach ($announcementInfoArray as $ann) {
        if ($ann['announcementID'] == $deletedID) {
            $deletedTitle = $ann['title'];
            break;
        }
    }
?>
<script>
    window.addEventListener('DOMContentLoaded', function () {
        var modal = new bootstrap.Modal(document.getElementById('confirmDeleteAnnouncementModalGeneric'));
        modal.show();
    });
</script>
<div class="modal fade" id="confirmDeleteAnnouncementModalGeneric" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; color: white;">
            <div class="modal-header" style="border: none;">
                <h4 class="modal-title heading text-center w-100 text-black">ANNOUNCEMENT DELETED</h4>
            </div>
            <div class="modal-body text-center text-black">
                The <strong><?= htmlspecialchars($deletedTitle) ?></strong> announcement has been successfully deleted.
            </div>
            <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>