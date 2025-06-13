<div id="workout" class="container">
  <div id="calendar" class="container px-0 py-4 mb-3 mt-2">
    <div class="row">
      <div class="col-12">
        <div class="heading">WORKOUT CALENDAR</div>
        <hr style="border-top: 3px solid #000; opacity: 1; margin:0;">

        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3 mt-5 mb-3">

          <!-- Entries Count first -->
          <div class="small text-muted text-start w-100 flex-sm-grow-0" style="max-width: 200px">
            Show
            <select id="entriesCount" class="form-select d-inline-block w-auto mx-1 small text-muted">
              <option value="5" selected>5</option>
              <option value="10">10</option>
              <option value="25">25</option>
              <option value="50">50</option>
            </select>
            entries
          </div>

          <!-- Search, Filter, and Add -->
          <div
            class="navigation-wrapper d-flex gap-2 align-items-center w-100 flex-sm-grow-0 justify-content-center justify-sm-end"
            style="max-width: 600px">
            <input id="searchInput" type="search" class="form-control w-100 w-sm-auto" placeholder="Search month…"
              style="max-width: 300px">
            <select id="orderBy" class="form-select" style="max-width: 200px">
              <option selected disabled>Order</option>
              <option value="asc">Ascending</option>
              <option value="desc">Descending</option>
            </select>

            <a class="btn btn-primary subheading text-nowrap" data-bs-toggle="modal" data-bs-target="#addWorkoutModal">
              ADD NEW
            </a>
          </div>

        </div>


        <!-- Add Workout Modal -->
        <div class="modal fade" id="addWorkoutModal" tabindex="-1" aria-labelledby="addWorkoutModalLabel"
          aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px;">
              <!-- Header -->
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

              <!-- Body -->
              <div class="modal-body" style="padding: 1.5rem;">
                <form id="AddWorkoutForm">
                  <div class="mb-3 text-start">
                    <label for="WorkoutDate" class="form-label fw-bold">Date</label>
                    <input type="date" class="form-control" id="AddWorkoutDate" name="AddWorkoutDate" value="">
                  </div>
                  <div class="mb-3 text-start">
                    <label for="WorkoutType" class="form-label fw-bold">Workout Type</label>
                    <select id="AddWorkoutType" name="AddWorkoutType" class="form-select" multiple>
                      <option disabled selected>Workout</option>
                      <option value="Cardio">Cardio</option>
                      <option value="ChestDay">Chest Day</option>
                      <option value="BackDay">Back Day</option>
                      <option value="LegDay">Leg Day</option>
                      <option value="ShoulderDay">Shoulder Day</option>
                      <option value="ArmDay">Arm Day</option>
                      <option value="AbsDay">Abs Day</option>
                      <option value="FullBody">Full Body</option>
                      <option value="RestDay">Rest Day</option>
                    </select>
                  </div>
                  <div class="mb-3 text-start">
                    <label for="WorkoutStatus" class="form-label fw-bold">Status</label>
                    <select id="AddWorkoutStatus" name="AddWorkoutStatus" class="form-select">
                      <option disabled selected>Status</option>
                      <option value="Scheduled">Planned</option>
                      <option value="Completed">Completed</option>
                      <option value="Cancelled">Skipped</option>
                      <option value="Cancelled">Scheduled</option>
                    </select>
                  </div>
                </form>
              </div>

              <!-- Footer -->
              <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                  CANCEL
                </button>
                <button type="button" class="btn btn-primary" style="margin-left: 0.5rem;" data-bs-toggle="modal"
                  data-bs-target="#confirmAddWorkoutModal">
                  SAVE CHANGES
                </button>
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
                This workout has been successfully added.
              </div>
              <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                  CLOSE
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="main px-2 px-md-0" style="transition: margin-left 0.25s ease-in-out;">
          <!-- User Table -->
          <div class="row">
            <div class="table-responsive">
              <table class="table table-striped table-borderless">
                <thead class="align-middle">
                  <tr>
                    <th scope="col">DATE</th>
                    <th scope="col">WORKOUT TYPE</th>
                    <th scope="col">STATUS</th>
                    <th class="text-center" scope="col">ACTION</th>
                  </tr>
                </thead>

                <!-- User Data -->
                <tbody>
                  <tr>
                    <td scope="row">March 01, 2025</td>
                    <td>Cardio</td>
                    <td>Completed</td>
                    <td class="d-flex flex-row justify-content-center">
                      <li>
                        <a data-bs-toggle="modal" data-bs-target="#editWorkoutModal">
                          <i class="bi bi-pencil-square px-2"></i>
                        </a>
                      </li>
                      <li>
                        <a style="color: red;" data-bs-toggle="modal" data-bs-target="#deleteWorkoutModal">
                          <i class="bi bi-trash3 px-2"></i>
                        </a>
                      </li>
                    </td>
                  </tr>

                  <tr>
                    <td scope="row">March 02, 2025</td>
                    <td>Strength</td>
                    <td>Skipped</td>
                    <td class="d-flex flex-row justify-content-center">
                      <li>
                        <a data-bs-toggle="modal" data-bs-target="#editWorkoutModal">
                          <i class="bi bi-pencil-square px-2"></i>
                        </a>
                      </li>
                      <li>
                        <a style="color: red;" data-bs-toggle="modal" data-bs-target="#deleteWorkoutModal">
                          <i class="bi bi-trash3 px-2"></i>
                        </a>
                      </li>
                    </td>
                  </tr>

                  <tr>
                    <td scope="row">March 03, 2025</td>
                    <td>Flexibility</td>
                    <td>Scheduled</td>
                    <td class="d-flex flex-row justify-content-center">
                      <li>
                        <a data-bs-toggle="modal" data-bs-target="#editWorkoutModal">
                          <i class="bi bi-pencil-square px-2"></i>
                        </a>
                      </li>
                      <li>
                        <a style="color: red;" data-bs-toggle="modal" data-bs-target="#deleteWorkoutModal">
                          <i class="bi bi-trash3 px-2"></i>
                        </a>
                      </li>
                    </td>
                  </tr>

                  <tr>
                    <td scope="row">March 04, 2025</td>
                    <td>Cardio</td>
                    <td>Skipped</td>
                    <td class="d-flex flex-row justify-content-center">
                      <li>
                        <a data-bs-toggle="modal" data-bs-target="#editWorkoutModal">
                          <i class="bi bi-pencil-square px-2"></i>
                        </a>
                      </li>
                      <li>
                        <a style="color: red;" data-bs-toggle="modal" data-bs-target="#deleteWorkoutModal">
                          <i class="bi bi-trash3 px-2"></i>
                        </a>
                      </li>
                    </td>
                  </tr>

                  <tr>
                    <td scope="row">March 05, 2025</td>
                    <td>Strength</td>
                    <td>Completed</td>
                    <td class="d-flex flex-row justify-content-center">
                      <li>
                        <a data-bs-toggle="modal" data-bs-target="#editWorkoutModal">
                          <i class="bi bi-pencil-square px-2"></i>
                        </a>
                      </li>
                      <li>
                        <a style="color: red;" data-bs-toggle="modal" data-bs-target="#deleteWorkoutModal">
                          <i class="bi bi-trash3 px-2"></i>
                        </a>
                      </li>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Edit Workout Modal -->
          <div class="modal fade" id="editWorkoutModal" tabindex="-1" aria-labelledby="editWorkoutModalLabel"
            aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content" style="border-radius: 15px;">
                <!-- Header -->
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

                <!-- Body -->
                <div class="modal-body" style="padding: 1.5rem;">
                  <form id="EditWorkoutForm">
                    <div class="mb-3 text-start">
                      <label for="WorkoutDate" class="form-label fw-bold">Date</label>
                      <input type="date" class="form-control" id="AddWorkoutDate" name="EditWorkoutDate" value="">
                    </div>
                    <div class="mb-3 text-start">
                      <label for="WorkoutType" class="form-label fw-bold">Workout Type</label>
                      <select id="EditWorkoutType" name="EditWorkoutType" class="form-select" multiple>
                        <option disabled selected>Workout</option>
                        <option value="Cardio">Cardio</option>
                        <option value="ChestDay">Chest Day</option>
                        <option value="BackDay">Back Day</option>
                        <option value="LegDay">Leg Day</option>
                        <option value="ShoulderDay">Shoulder Day</option>
                        <option value="ArmDay">Arm Day</option>
                        <option value="AbsDay">Abs Day</option>
                        <option value="FullBody">Full Body</option>
                        <option value="RestDay">Rest Day</option>
                      </select>
                    </div>
                    <div class="mb-3 text-start">
                      <label for="WorkoutStatus" class="form-label fw-bold">Status</label>
                      <select id="EditWorkoutStatus" name="EditWorkoutStatus" class="form-select">
                        <option disabled selected>Status</option>
                        <option value="Scheduled">Planned</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancelled">Skipped</option>
                        <option value="Cancelled">Scheduled</option>
                      </select>
                    </div>
                  </form>
                </div>

                <!-- Footer -->
                <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    CANCEL
                  </button>
                  <button type="button" class="btn btn-primary" style="margin-left: 0.5rem;" data-bs-toggle="modal"
                    data-bs-target="#confirmEditWorkoutModal">
                    SAVE CHANGES
                  </button>
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
                  This workout has been successfully edited.
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
          <div class="modal fade" id="deleteWorkoutModal" tabindex="-1" aria-labelledby="deleteWorkoutModalLabel"
            aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content" style="border-radius: 15px;">
                <!-- Header -->
                <div
                  style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                  <h4 class="modal-title text-center subheading" id="deleteWorkoutModalLabel"
                    style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                    DELETE WORKOUT
                  </h4>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                    style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;"></button>
                </div>

                <!-- Body -->
                <div class="modal-body text-center" style="padding: 1.5rem;">
                  <p style="margin: 0; font-size: 16px; color: black;">
                    Are you sure you want to delete this workout? <br><br>If you
                    decided to delete this workout, it will be permanently removed from your workout history.
                  </p>
                </div>

                <!-- Footer -->
                <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    CANCEL
                  </button>
                  <button type="button" class="btn btn-primary" style="margin-left: 0.5rem;" data-bs-toggle="modal"
                    data-bs-target="#confirmdeleteWorkoutModal" data-bs-dismiss="modal">
                    DELETE
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Confirm Delete Workout Modal -->
          <div class="modal fade" id="confirmdeleteWorkoutModal" tabindex="-1"
            aria-labelledby="confirmDeleteWorkoutModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
                <div class="modal-header" style="border: none;">
                  <h4 class="modal-title heading text-center w-100 text-black" id="confirmDeleteWorkoutModalLabel"
                    style="margin: 0;">
                    WORKOUT DELETED
                  </h4>
                </div>
                <div class="modal-body text-center text-black">
                  This workout has been successfully deleted.
                </div>
                <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                  <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                    CLOSE
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Bottom Pagination Info -->
          <div class="d-flex justify-content-between align-items-center">
            <div class="small text-muted">
              Showing 2 of 2 entries
            </div>
            <nav aria-label="Page navigation example">
              <ul class="pagination mt-3">
                <li class="page-item">
                  <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                  </a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                  <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                  </a>
                </li>
              </ul>
            </nav>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div id="satistics" class="container px-0 py-4 mb-3 mt-2">
    <div class="row">
      <div class="col-12">
        <div class="heading">WORKOUT STATISTICS</div>
        <hr style="border-top: 3px solid #000; opacity: 1; margin:0;">
        <div class="row justify-content-center mt-3">
          <!-- Chart 1 Card -->
          <div class="col-md-6 col-12 d-flex justify-content-center">
            <div class="card border-0 bg-transparent" style="width: 100%; max-width: 400px;">
              <div class="card-body d-flex flex-column align-items-center">
                <div class="subheading w-100 text-lg-start">WORKOUT TYPE TRACKER</div>
                <canvas id="pieChart"></canvas>
              </div>
            </div>
          </div>

          <!-- Chart 2 Card -->
          <div class="col-md-6 col-12 d-flex justify-content-center">
            <div class="card border-0 bg-transparent" style="width: 100%; max-width: 500px;">
              <div class="card-body d-flex flex-column align-items-center">
                <div class="subheading mb-5 w-100 text-md-center text-lg-center">WEEKLY WORKOUT FREQUENCY</div>
                <canvas id="barChart"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // Pie Chart Data
  var pieLabels = ["Cardio", "Strength", "Flexibility"];
  var pieData = [55, 49, 44];
  var pieColors = ["#1f2a3c", "#334566", "#60779c"];

  new Chart("pieChart", {
    type: "pie",
    data: {
      labels: pieLabels,
      datasets: [{
        backgroundColor: pieColors,
        data: pieData
      }]
    },
    options: {
      plugins: {
        title: { display: false },
        legend: {
          position: 'right',
          labels: {
            usePointStyle: true,
            pointStyle: 'circle',
            font: { size: 14 },
            pointStyleWidth: 18,
            padding: 20
          }
        }
      }
    }
  });

  // Bar Chart Data
  var barLabels = ["Week 1", "Week 2", "Week 3"];
  var barData = [2, 4, 3, 5, 6, 7];
  var barColors = ["#b0b0b0", "#1f2a3c ", "#60779c"];

  new Chart("barChart", {
    type: "bar",
    data: {
      labels: barLabels,
      datasets: [{
        backgroundColor: barColors,
        data: barData
      }]
    },
    options: {
      plugins: {
        legend: { display: false },
        title: { display: false }
      },
      scales: {
        x: { grid: { display: false } },
        y: { grid: { display: false }, suggestedMin: 0, suggestedMax: 7 }
      }
    }
  });
</script>

<!-- Dialogflow Chatbot  -->
<?php include("views/chatbot.html"); ?>