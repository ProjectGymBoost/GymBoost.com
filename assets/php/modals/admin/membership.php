<?php foreach ($membershipArray as $info): ?>
    <!-- Edit Membership Modal -->
    <div class="modal fade" id="editMembershipModal<?= $info['userMembershipID']; ?>" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
            <div class="modal-content" style="border-radius: 15px;">
                <!-- Header -->
                <div style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                    <h4 class="modal-title text-center subheading" style="margin: 0; font-size: 20px; letter-spacing: 2px;">EDIT MEMBERSHIP</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                        style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;">
                    </button>
                </div>

                <!-- Form -->
                <form method="post">
                    <!-- Body -->
                    <div class="modal-body" style="padding: 1.5rem;">
                        <input type="hidden" name="editMembershipId" value="<?= $info['userMembershipID']; ?>">
                        <input type="hidden" name="editFirstName" value="<?= $info['firstName']; ?>">
                        <input type="hidden" name="editLastName" value="<?= $info['lastName']; ?>">

                        <div class="mb-3 text-start">
                            <label class="form-label fw-bold">First Name</label>
                            <div class="form-control-plaintext"><?= htmlspecialchars($info['firstName']); ?></div>
                        </div>
                        <div class="mb-3 text-start">
                            <label class="form-label fw-bold">Last Name</label>
                            <div class="form-control-plaintext"><?= htmlspecialchars($info['lastName']); ?></div>
                        </div>
                        <div class="mb-3 text-start">
                            <label for="editPlan<?= $info['userMembershipID']; ?>" class="form-label fw-bold">Membership Plan</label>
                            <select class="form-select" id="editPlan<?= $info['userMembershipID']; ?>" name="editMembershipPlan" required>
                                <option disabled>Select a plan</option>
                                <?php foreach ($membershipPlans as $plan): ?>
                                <option 
                                    value="<?= $plan['membershipID']; ?>" 
                                    data-requirement="<?= $plan['requirement']; ?>"
                                    <?= ($plan['membershipID'] == $info['membershipID']) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($plan['planType']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3 text-start">
                            <label class="form-label fw-bold">Start Date</label>
                            <input type="date" class="form-control" name="editStartDate" value="<?= $info['startDate']; ?>" required>
                        </div>
                        <div class="mb-3 text-start">
                            <label class="form-label fw-bold">End Date</label>
                            <input type="date" class="form-control" name="editEndDate" value="<?= $info['endDate']; ?>" required>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" name="btnEditMembership" class="btn btn-primary" style="margin-left: 0.5rem;">SAVE CHANGES</button>
                    </div>
                </form>

                <!-- For Automatic Calculation of End Date for Membership Plans -->
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const planSelect = document.getElementById('editPlan<?= $info['userMembershipID']; ?>');
                        const startDateInput = document.querySelector('#editMembershipModal<?= $info['userMembershipID']; ?> input[name="editStartDate"]');
                        const endDateInput = document.querySelector('#editMembershipModal<?= $info['userMembershipID']; ?> input[name="editEndDate"]');

                        if (!planSelect || !startDateInput || !endDateInput) return;

                        function updateEndDate() {
                        const selectedOption = planSelect.options[planSelect.selectedIndex];
                        const requirement = selectedOption.getAttribute('data-requirement'); // e.g., "30 days"

                        const daysMatch = requirement.match(/(\d+)\s*days?/i);
                        if (!daysMatch) return;

                        const duration = parseInt(daysMatch[1], 10);
                        const startDate = new Date(startDateInput.value);
                        if (isNaN(duration) || isNaN(startDate.getTime())) return;

                        const endDate = new Date(startDate);
                        endDate.setDate(endDate.getDate() + duration);

                        const yyyy = endDate.getFullYear();
                        const mm = String(endDate.getMonth() + 1).padStart(2, '0');
                        const dd = String(endDate.getDate()).padStart(2, '0');

                        endDateInput.value = `${yyyy}-${mm}-${dd}`;
                        }

                        planSelect.addEventListener('change', updateEndDate);
                        startDateInput.addEventListener('change', updateEndDate);
                    });
                </script>
            </div>
        </div>
    </div>

    <!-- Confirm Edit Modal -->
    <?php if (isset($_GET['updated']) && $_GET['updated'] == '1' && $_GET['name'] == $info['firstName'] . ' ' . $info['lastName']): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modal = new bootstrap.Modal(document.getElementById('confirmEditMembershipModal<?= $info['userMembershipID']; ?>'));
                modal.show();
                const url = new URL(window.location);
                url.searchParams.delete('updated');
                url.searchParams.delete('name');
                history.replaceState(null, '', url.toString());
            });
        </script>

        <div class="modal fade" id="confirmEditMembershipModal<?= $info['userMembershipID']; ?>" tabindex="-1" aria-hidden="true">
           <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 15px; border: none;">
                    <div class="modal-header border-0">
                        <h4 class="modal-title heading text-center w-100 text-black m-0">MEMBERSHIP UPDATED</h4>
                    </div>
                    <div class="modal-body text-center text-black">
                        <strong><?= ($info['firstName'] . ' ' . $info['lastName']); ?>'s</strong> membership has been successfully edited.
                    </div>
                    <div class="modal-footer d-flex justify-content-center pb-4 border-0">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Delete Membership Modal -->
    <div class="modal fade" id="deleteMembershipModal<?= $info['userMembershipID']; ?>" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
       <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px;">
                <div style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                    <h4 class="modal-title text-center subheading" style="margin: 0; font-size: 20px; letter-spacing: 2px;">DELETE MEMBERSHIP</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                        style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;">
                    </button>
                </div>

                <div class="modal-body text-center" style="padding: 1.5rem;">
                    <p style="margin: 0; font-size: 16px; color: black;">
                        <span style="color: #D2042D;">Are you sure you want to delete <strong><?= ($info['firstName'] . ' ' . $info['lastName']); ?>'s</strong> membership?</span><br><br>
                        If you decided to delete this, you will cancel the user's membership.
                    </p>
                </div>

                <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                    <form method="post">
                        <input type="hidden" name="deleteMembershipId" value="<?= $info['userMembershipID']; ?>">
                        <input type="hidden" name="deleteName" value="<?= $info['firstName'] . ' ' . $info['lastName']; ?>">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" name="btnDeleteMembership" class="btn btn-primary" style="margin-left: 0.5rem;">DELETE</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Confirm Delete Modal -->
<?php if (isset($_GET['deleted']) && $_GET['deleted'] == '1' && isset($_GET['name'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = new bootstrap.Modal(document.getElementById('confirmDeleteMembershipModalGeneric'));
            modal.show();

            const url = new URL(window.location);
            url.searchParams.delete('deleted');
            url.searchParams.delete('deletedID');
            url.searchParams.delete('name');
            history.replaceState(null, '', url.toString());
        });
    </script>

    <div class="modal fade" id="confirmDeleteMembershipModalGeneric" tabindex="-1" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px; border: none;">
                <div class="modal-header border-0">
                    <h4 class="modal-title heading text-center w-100 text-black m-0">MEMBERSHIP DELETED</h4>
                </div>
                <div class="modal-body text-center text-black">
                    <strong><?= (htmlspecialchars($_GET['name'])); ?>'s</strong> membership has been successfully deleted.
                </div>
                <div class="modal-footer d-flex justify-content-center pb-4 border-0">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
