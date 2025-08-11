<?php
$editPlanErrors = $_SESSION['editPlanErrors'] ?? [];
$editPlanData = $_SESSION['editPlanData'] ?? [];
?>
<?php if (!empty($editPlanErrors)): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            <?php foreach ($editPlanErrors as $membershipID => $errors): ?>
                const modalId = "editMembershipPlanModal<?= (int) $membershipID ?>";
                const modalEl = document.getElementById(modalId);
                if (modalEl) {
                    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                    const editModal = new bootstrap.Modal(modalEl);
                    editModal.show();

                    const sessionData = <?= json_encode($editPlanData[(int) $membershipID] ?? []) ?>;
                    Object.entries(sessionData).forEach(([field, value]) => {
                        const input = modalEl.querySelector(`[name="${field}"]`);
                        if (input) input.value = value;
                    });
                }
            <?php endforeach; ?>
        });
    </script>
<?php endif; ?>


<?php foreach ($membershipPlanInfoArray as $info): ?>
    <div class="modal fade" id="editMembershipPlanModal<?= $info['membershipID'] ?>" tabindex="-1"
        aria-labelledby="editMembershipPlanModalLabel<?= $info['membershipID'] ?>" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px;">
                <!-- Header -->
                <div
                    style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                    <h4 class="modal-title text-center subheading"
                        id="editMembershipPlanModalLabel<?= $info['membershipID'] ?>"
                        style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                        EDIT MEMBERSHIP PLAN
                    </h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                        style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;">
                    </button>
                </div>

                <!-- Body -->
                <div class="modal-body" style="padding: 1.5rem;">
                    <form id="editMembershipForm<?= $info['membershipID'] ?>" method="POST" action="">
                        <input type="hidden" name="membershipID" value="<?= htmlspecialchars($info['membershipID']) ?>">

                        <!-- Plan Type -->
                        <div class="mb-4 text-start">
                            <label for="editPlanType<?= $info['membershipID'] ?>" class="form-label fw-bold">Plan
                                Type</label>
                            <input type="text" id="editPlanType<?= $info['membershipID'] ?>" name="planType"
                                data-original-value="<?= htmlspecialchars($info['planType']) ?>"
                                class="form-control <?= isset($editPlanErrors[$info['membershipID']]['planType']) ? 'is-invalid' : '' ?>"
                                value="<?= htmlspecialchars($editPlanData[$info['membershipID']]['planType'] ?? $info['planType']) ?>">
                            <div id="editPlanTypeError<?= $info['membershipID'] ?>" class="invalid-feedback small">
                                <?= $editPlanErrors[$info['membershipID']]['planType'] ?? '' ?>
                            </div>
                        </div>

                        <!-- Requirement -->
                        <div class="mb-4 text-start">
                            <label for="editRequirement<?= $info['membershipID'] ?>" class="form-label fw-bold">Requirement
                                (in days)</label>
                            <input type="text" id="editRequirement<?= $info['membershipID'] ?>" name="requirement"
                                data-original-value="<?= htmlspecialchars($info['requirement']) ?>"
                                class="form-control <?= isset($editPlanErrors[$info['membershipID']]['requirement']) ? 'is-invalid' : '' ?>"
                                value="<?= htmlspecialchars($editPlanData[$info['membershipID']]['requirement'] ?? $info['requirement']) ?>">
                            <div id="editRequirementError<?= $info['membershipID'] ?>" class="invalid-feedback small">
                                <?= $editPlanErrors[$info['membershipID']]['requirement'] ?? '' ?>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="mb-4 text-start">
                            <label for="editPrice<?= $info['membershipID'] ?>" class="form-label fw-bold">Price (₱)</label>
                            <input type="text" id="editPrice<?= $info['membershipID'] ?>" name="price"
                                data-original-value="<?= htmlspecialchars($info['price']) ?>"
                                class="form-control <?= isset($editPlanErrors[$info['membershipID']]['price']) ? 'is-invalid' : '' ?>"
                                value="<?= htmlspecialchars(number_format($editPlanData[$info['membershipID']]['price'] ?? $info['price'], 2)) ?>">
                            <div id="editPriceError<?= $info['membershipID'] ?>" class="invalid-feedback small">
                                <?= $editPlanErrors[$info['membershipID']]['price'] ?? '' ?>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="modal-footer d-flex justify-content-end gap-1 p-0 m-0" style="border: none; padding: 1rem;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                            <button type="submit" name="btnEditMembershipPlan" class="btn btn-primary m-0">
                                SAVE CHANGES
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    unset($_SESSION['editPlanErrors'], $_SESSION['editPlanData']);
    ?>


    <!-- Confirm Edit Membership Plan Modal -->
    <?php if (isset($_GET['updated']) && $_GET['updated'] == '1'): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                setTimeout(function () {
                    const confirmModalEl = document.getElementById('confirmEditMembershipPlanModal');
                    if (confirmModalEl) {
                        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                        const confirmModal = new bootstrap.Modal(confirmModalEl);
                        confirmModal.show();

                        confirmModalEl.addEventListener('hidden.bs.modal', function () {
                            document.body.style.overflow = 'auto';
                            document.body.classList.remove('modal-open');
                        });

                        const url = new URL(window.location);
                        url.searchParams.delete('updated');
                        window.history.replaceState({}, document.title, url);
                    }
                }, 100);
            });
        </script>
    <?php endif; ?>

    <div class="modal fade" id="confirmEditMembershipPlanModal" tabindex="-1"
        aria-labelledby="confirmEditMembershipModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
                <div class="modal-header" style="border: none;">
                    <h4 class="modal-title heading text-center w-100 text-black" id="confirmEditMembershipModalLabel"
                        style="margin: 0;">
                        MEMBERSHIP PLAN UPDATED
                    </h4>
                </div>
                <div class="modal-body text-center text-black">
                    Membership Plan has been successfully edited.
                </div>
                <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                        CLOSE
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Membership Plan Modal -->
    <div class="modal fade" id="deleteMembershipPlanModal<?= $info['membershipID'] ?>" tabindex="-1"
        aria-labelledby="deleteMembershipPlanModalLabel<?= $info['membershipID'] ?>" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px;">
                <!-- Header -->
                <div
                    style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                    <h4 class="modal-title text-center subheading"
                        id="deleteMembershipPlanModalLabel<?= $info['membershipID'] ?>"
                        style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                        DELETE MEMBERSHIP PLAN
                    </h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                        style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;">
                    </button>
                </div>

                <!-- Body -->
                <div class="modal-body text-center" style="padding: 1.5rem;">
                    <p style="margin: 0; font-size: 16px; color: black;">
                        <span style="color: #D2042D;">
                            Are you sure you want to delete
                            <span style="font-weight: bold;">
                                <?= ($info['planType']) ?>
                            </span>membership plan?
                        </span>
                    </p>
                </div>

                <!-- Footer -->
                <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        CANCEL
                    </button>
                    <form method="POST">
                        <button type="submit" name="btnDeleteMembershipPlan" class="btn btn-primary"
                            style="margin-left: 0.5rem;">
                            DELETE
                        </button>
                        <input type="hidden" name="membershipID" value="<?= $info['membershipID']; ?>">
                        <input type="hidden" name="planType" value="<?= $info['planType']; ?>">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Delete Membership Plan Modal -->
    <?php if (isset($_GET['deleted']) && $_GET['deleted'] == '1'): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                setTimeout(function () {
                    const confirmModalEl = document.getElementById('confirmDeleteMembershipPlanModal');
                    if (confirmModalEl) {
                        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                        const confirmModal = new bootstrap.Modal(confirmModalEl);
                        confirmModal.show();

                        confirmModalEl.addEventListener('hidden.bs.modal', function () {
                            document.body.style.overflow = 'auto';
                            document.body.classList.remove('modal-open');
                        });

                        const url = new URL(window.location);
                        url.searchParams.delete('deleted');
                        window.history.replaceState({}, document.title, url);
                    }
                });
            });
        </script>
    <?php endif; ?>
<?php endforeach; ?>

<div class="modal fade" id="confirmDeleteMembershipPlanModal" tabindex="-1"
    aria-labelledby="confirmDeleteMembershipPlanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; color: black; border: none;">
            <div class="modal-header" style="border: none;">
                <h4 class="modal-title heading text-center w-100" id="confirmDeleteMembershipPlanLabel"
                    style="margin: 0;">
                    MEMBERSHIP PLAN DELETED
                </h4>
            </div>
            <div class="modal-body text-center">
                Membership plan has been successfully deleted.
            </div>
            <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                    CLOSE
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add New Membership Plan Modal -->
<div class="modal fade" id="addMembershipModal" tabindex="-1" aria-labelledby="addMembershipModalLabel"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <div
                style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                <h4 class="modal-title text-center subheading" id="addMembershipModalLabel"
                    style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                    ADD NEW MEMBERSHIP PLAN
                </h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                    style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;">
                </button>
            </div>

            <form id="addMembershipForm" method="POST" novalidate>
                <div class="modal-body" style="padding: 1.5rem;">

                    <div class="mb-4 text-start">
                        <label for="planType" class="form-label fw-bold">Plan Type</label>
                        <input type="text" name="planType" id="planType"
                            class="form-control <?= isset($_SESSION['addPlanErrors']['planType']) ? 'is-invalid' : (isset($_SESSION['planType']) ? 'is-valid' : '') ?>"
                            placeholder="e.g., Monthly" value="<?= htmlspecialchars($_SESSION['planType'] ?? '') ?>">
                        <div id="planTypeError" class="invalid-feedback">
                            <?= $_SESSION['addPlanErrors']['planType'] ?? '' ?>
                        </div>
                    </div>

                    <div class="mb-4 text-start">
                        <label for="requirement" class="form-label fw-bold">Requirement (in days)</label>
                        <input type="text" name="requirement" id="requirement"
                            class="form-control <?= isset($_SESSION['addPlanErrors']['requirement']) ? 'is-invalid' : (isset($_SESSION['requirement']) ? 'is-valid' : '') ?>"
                            placeholder="e.g., 1 day or 30 days"
                            value="<?= htmlspecialchars($_SESSION['requirement'] ?? '') ?>">
                        <div id="requirementError" class="invalid-feedback">
                            <?= $_SESSION['addPlanErrors']['requirement'] ?? '' ?>
                        </div>
                    </div>

                    <div class="mb-4 text-start">
                        <label for="price" class="form-label fw-bold">Price (₱)</label>
                        <input type="text" name="price" id="price"
                            class="form-control <?= isset($_SESSION['addPlanErrors']['price']) ? 'is-invalid' : (isset($_SESSION['price']) ? 'is-valid' : '') ?>"
                            placeholder="e.g., 1,100.00 or 100.00"
                            value="<?= htmlspecialchars($_SESSION['price'] ?? '') ?>">
                        <div id="priceError" class="invalid-feedback">
                            <?= $_SESSION['addPlanErrors']['price'] ?? '' ?>
                        </div>
                    </div>

                    <div class="modal-footer d-flex justify-content-end gap-1 p-0 m-0" style="border: none; padding: 1rem;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" name="btnAddMembershipPlan" class="btn btn-primary m-0">ADD</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if (!empty($_SESSION['addPlanErrors'])): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const existingBackdrop = document.querySelector('.modal-backdrop');
            if (existingBackdrop) existingBackdrop.remove();

            const addModalEl = document.getElementById('addMembershipModal');
            if (addModalEl) {
                const addModal = bootstrap.Modal.getOrCreateInstance(addModalEl);
                addModal.show();
            }
        });
    </script>
<?php endif; ?>



<?php
unset($_SESSION['addPlanErrors'], $_SESSION['planType'], $_SESSION['requirement'], $_SESSION['price']);
?>

<!-- Confirmation modal after success -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        function removeBackdrops() {
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
        }
        <?php if (!empty($_SESSION['addPlanErrors'])): ?>
            removeBackdrops();
            const addModal = new bootstrap.Modal(document.getElementById('addMembershipModal'));
            addModal.show();
        <?php endif; ?>

        <?php if (isset($_GET['added'])): ?>
            setTimeout(() => {
                removeBackdrops();
                const confirmModal = new bootstrap.Modal(document.getElementById('confirmAddMembershipModal'));
                confirmModal.show();

                const url = new URL(window.location);
                url.searchParams.delete('added');
                window.history.replaceState({}, document.title, url);
            }, 300);
        <?php endif; ?>
    });
</script>

<?php
unset($_SESSION['addPlanErrors']);
unset($_SESSION['planType'], $_SESSION['requirement'], $_SESSION['price']);
?>
<div class="modal fade" id="confirmAddMembershipModal" tabindex="-1" aria-labelledby="confirmAddMembershipModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
            <div class="modal-header" style="border: none;">
                <h4 class="modal-title heading text-center w-100 text-black" id="confirmAddMembershipModalLabel"
                    style="margin: 0;">
                    MEMBERSHIP PLAN ADDED
                </h4>
            </div>
            <div class="modal-body text-center text-black">
                New membership plan has been successfully added.
            </div>
            <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>
<script>
    function cleanBackdrops() {
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
    }
</script>