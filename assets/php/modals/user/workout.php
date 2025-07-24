<!-- Add Workout Modal -->
<div class="modal fade" id="addWorkoutModal" tabindex="-1" aria-labelledby="addWorkoutModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <div
                style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                <h4 class="modal-title text-center subheading" id="addWorkoutModalLabel"
                    style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                    ADD NEW WORKOUT
                </h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                    style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;">
                </button>
            </div>
            <div class="modal-body" style="padding: 1.5rem;">
                <form id="AddWorkoutForm" method="POST">
                    <div class="row">
                        <div class="mb-4 text-start">
                            <input type="hidden" name="addWorkout" value="1">
                            <input type="hidden" name="userID" value="<?php echo $_SESSION['userID']; ?>">
                            <label for="WorkoutType" class="form-label">Workout Type</label>
                            <select id="addWorkoutType" name="workoutType[]" class="form-select" multiple required>
                                <option value="Cardio">Cardio</option>
                                <option value="Chest">Chest</option>
                                <option value="Back">Back</option>
                                <option value="Leg">Leg</option>
                                <option value="Shoulder">Shoulder</option>
                                <option value="Arm">Arm</option>
                                <option value="Abs">Abs</option>
                                <option value="Full Body">Full Body</option>
                                <option value="Rest">Rest</option>
                            </select>
                        </div>

                        <div class="col-6 col-md-4">
                            <label for="eventStart" class="form-label">Start Date</label>
                            <input type="date" name="startDate" class="form-control" id="eventStart" required />
                        </div>

                        <div class="col-6 col-md-4">
                            <label for="eventEnd" class="form-label">End Date</label>
                            <input type="date" name="endDate" class="form-control" id="eventEnd" required />
                        </div>

                        <div class="col-12 col-md-4">
                            <label for="workoutColor" class="form-label">Color</label>
                            <input type="color" name="color" class="form-control form-control-color w-100"
                                id="workoutColor" value="#28364e" />
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem 0 0 0;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            CANCEL
                        </button>
                        <button type="submit" class="btn btn-primary" name="addWorkout">
                            ADD
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Confirm Add Workout Modal -->
<div class="modal fade" id="confirmAddWorkoutModal" tabindex="-1" aria-labelledby="confirmAddWorkoutLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
            <div class="modal-header" style="border: none;">
                <h4 class="modal-title heading text-center w-100 text-black" id="confirmAddWorkoutModalLabel"
                    style="margin: 0;">
                    WORKOUT ADDED
                </h4>
            </div>
            <div class="modal-body text-center text-black">
                The workout/s has been successfully added.
            </div>
            <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                    CLOSE
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Workout Modal -->
<div class="modal fade" id="editWorkoutModal" tabindex="-1" aria-labelledby="editWorkoutModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <div
                style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                <h4 class="modal-title text-center subheading" id="editWorkoutModalLabel"
                    style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                    EDIT WORKOUT
                </h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                    style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;">
                </button>
            </div>
            <div class="modal-body" style="padding: 1.5rem;">
                <form id="editWorkoutForm" method="post">
                    <div class="row">
                        <input type="hidden" name="editWorkoutID" id="editWorkoutID">
                        <div class="mb-4 text-start">
                            <label for="editWorkoutType" class="form-label">Workout Type</label>
                            <select id="editWorkoutType" name="editWorkoutType[]" class="form-select" multiple required>
                                <option disabled selected>Workout</option>
                                <option value="Cardio">Cardio</option>
                                <option value="Chest">Chest</option>
                                <option value="Back">Back</option>
                                <option value="Leg">Leg</option>
                                <option value="Shoulder">Shoulder</option>
                                <option value="Arm">Arm</option>
                                <option value="Abs">Abs</option>
                                <option value="Full Body">Full Body</option>
                                <option value="Rest">Rest</option>
                            </select>
                        </div>

                        <div class="col-6 col-md-4">
                            <label for="editWorkoutStart" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="editWorkoutStart" name="editWorkoutStart" required />
                        </div>

                        <div class="col-6 col-md-4">
                            <label for="editWorkoutEnd" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="editWorkoutEnd" name="editWorkoutEnd" required />
                        </div>

                        <div class="col-12 col-md-4">
                            <label for="editWorkoutColor" class="form-label">Color</label>
                            <input type="color" class="form-control form-control-color w-100" id="editWorkoutColor"
                                value="#28364e" name="editWorkoutColor" />
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem 0 0 0;">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                            onclick="openDeleteModal()">
                            DELETE
                        </button>
                        <button type="submit" name="editWorkout" class="btn btn-primary">
                            SAVE CHANGES
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Confirm Edit Workout Modal -->
<div class="modal fade" id="confirmEditWorkoutModal" tabindex="-1" aria-labelledby="confirmEditWorkoutLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
            <div class="modal-header" style="border: none;">
                <h4 class="modal-title heading text-center w-100 text-black" id="confirmEditWorkoutModalLabel"
                    style="margin: 0;">
                    WORKOUT UPDATED
                </h4>
            </div>
            <div class="modal-body text-center text-black">
                The workout/s has been successfully edited.
            </div>
            <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                    CLOSE
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Workout Modal -->
<?php foreach ($calendar->events as $event): ?>
    <?php
    $titles = explode(', ', $event['title']);
    ?>
    <div class="modal fade" id="deleteWorkoutModal<?= $event['id'] ?>" tabindex="-1"
        aria-labelledby="deleteWorkoutModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px;">
                <div
                    style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                    <h4 class="modal-title text-center subheading" id="deleteWorkoutModalLabel"
                        style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                        DELETE WORKOUT
                    </h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                        style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;"></button>
                </div>

                <form id="deleteWorkoutForm" method="post">
                    <div class="modal-body text-center" style="padding: 1.5rem;">
                        <p style="margin: 0; font-size: 16px; color: black;">
                            <span style="color: #D2042D;">
                                Are you sure you want to delete the
                                <strong><?= $calendar->formatWorkoutList($titles) ?></strong>
                                workout<?= count($titles) > 1 ? 's' : '' ?>?
                            </span><br><br>
                            If you decided to delete this workout, it will be permanently removed from your workout history.
                        </p>
                        <input type="hidden" name="deleteWorkoutID" id="deleteWorkoutID" value="<?= $event['id'] ?>">
                        <input type="hidden" name="userID" value="<?= $userID ?>">
                    </div>
                    <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            CANCEL
                        </button>
                        <button type="submit" class="btn btn-primary" style="margin-left: 0.5rem;" name="deleteWorkout">
                            DELETE
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Confirm Delete Workout Modal -->
<div class="modal fade" id="confirmDeleteWorkoutModal" tabindex="-1" aria-labelledby="confirmDeleteWorkoutModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
            <div class="modal-header" style="border: none;">
                <h4 class="modal-title heading text-center w-100 text-black" id="confirmDeleteWorkoutModalLabel"
                    style="margin: 0;">
                    WORKOUT DELETED
                </h4>
            </div>
            <div class="modal-body text-center text-black">
                The workout/s has been successfully deleted.
            </div>
            <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                    CLOSE
                </button>
            </div>
        </div>
    </div>
</div>