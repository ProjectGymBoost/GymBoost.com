<!-- attendance modals -->
<?php if (!empty($userInfoArray)): ?>
  <?php foreach ($userInfoArray as $info): ?>
    <div class="modal fade" id="deleteUserModal<?= $info['userID']; ?>" tabindex="-1"
         aria-labelledby="deleteUserModalLabel" aria-hidden="true"
         data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
          <div style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
            <h4 class="modal-title text-center subheading" id="deleteUserModalLabel"
                style="margin: 0; font-size: 20px; letter-spacing: 2px;">
              DELETE USER ATTENDANCE
            </h4>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                    style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;">
            </button>
          </div>
          <div class="modal-body text-center" style="padding: 1.5rem;">
            <p style="margin: 0; font-size: 16px;">
              <span style="color: #D2042D;">
                Are you sure you want to delete
                <span style="font-weight: bold;">
                  <?= ($info['firstName'] . ' ' . $info['lastName']) ?>
                </span>'s attendance record?
              </span>
              <br><br>
              Once deleted, this user’s attendance info and related logs can’t be recovered.
            </p>
          </div>
          <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
            <form method="POST">
              <input type="hidden" name="deleteAttendanceId" value="<?= $info['attendanceID']; ?>">
              <input type="hidden" name="deleteFirstName" value="<?= $info['firstName']; ?>">
              <input type="hidden" name="deleteLastName" value="<?= $info['lastName']; ?>">
              <input type="hidden" name="deleteDate" value="<?= $info['checkinDate']; ?>">
              <button type="submit" class="btn btn-primary" name="btnDelete">DELETE</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>

<!-- Confirm Delete Success Modal (always present) -->
<div class="modal fade" id="confirmDeleteAttendanceModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 15px;">
      <div class="modal-header border-0">
        <h4 class="modal-title heading text-center w-100 text-black">ATTENDANCE RECORD DELETED</h4>
      </div>
      <?php $deletedName = trim($_GET['name'] ?? ''); ?>
      <div class="modal-body text-center">
        <?php if ($deletedName): ?>
          <strong><span style="color: #D2042D; font-weight: bold;"><?= htmlspecialchars($deletedName) ?>'s</span></strong>
          attendance record has been successfully deleted.
        <?php else: ?>
          Attendance record has been successfully deleted.
        <?php endif; ?>
      </div>
      <div class="modal-footer d-flex justify-content-center pb-4 border-0">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">CLOSE</button>
      </div>
    </div>
  </div>
</div>

<?php if (isset($_GET['deleted']) && $_GET['deleted'] == '1'): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
  setTimeout(function () {
    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
    const confirmModalEl = document.getElementById('confirmDeleteAttendanceModal');
    if (confirmModalEl) {
      const confirmModal = new bootstrap.Modal(confirmModalEl, { backdrop: 'static', keyboard: true });
      confirmModal.show();

      confirmModalEl.addEventListener('hidden.bs.modal', function () {
        const url = new URL(window.location);
        url.searchParams.delete('highlight');
        window.history.replaceState({}, document.title, url);
      });
    }
  }, 150);
});
</script>
<?php endif; ?>
