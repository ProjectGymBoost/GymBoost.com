<?php
include("../assets/php/classes/classes.php");
$userID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;
$calendar = new WorkoutCalendar();

if ($userID) {
  $calendar->handleWorkoutActions($userID);
  $calendar->loadEvents($userID);
}
$eventsJSON = $calendar->getEvents();
?>

<div id="workout" class="container">
  <div class="container-lg px-0 py-4 mb-3 mt-2">
    <div class="row">
      <div class="col-12">
        <div class="heading">WORKOUT CALENDAR</div>
        <hr style="border-top: 3px solid #000; opacity: 1; margin:0;">
        <div class="card border-0 shadow-sm my-5">
          <div class="card-header bg-white border-bottom-0">
            <div class="d-flex justify-content-between align-items-center mt-4">
              <div class="fs-6 fw-semibold text-muted ps-2 schedule-header-sm">SCHEDULE MANAGER</div>
              <div class="calendar-instructions dropdown">
                <div class="btn btn-outline-secondary dropdown-toggle me-2" type="button" id="calendarHelpDropdown"
                  data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-question-circle me-1"></i> How to use
                </div>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="calendarHelpDropdown"
                  style="min-width: 280px; min-height: 220px">
                  <li class="py-1">
                    <span class="dropdown-item-text ps-3"><strong class="text-muted">Create Event:</strong> Click any
                      date on calendar</span>
                  </li>
                  <li class="py-1">
                    <span class="dropdown-item-text ps-3"><strong class="text-muted">Edit Event:</strong> Click on
                      existing event</span>
                  </li>
                  <li class="py-1">
                    <span class="dropdown-item-text ps-3"><strong class="text-muted">Move Event:</strong> Drag and drop
                      to new date</span>
                  </li>
                  <li class="py-1">
                    <span class="dropdown-item-text ps-3"><strong class="text-muted">Delete Event:</strong> Click event
                      then click delete button</span>
                  </li>
                  <li class="py-1">
                    <span class="dropdown-item-text ps-3"><strong class="text-muted">Switch Month:</strong> Use
                      left/right arrows at the top of the calendar</span>
                  </li>
                  <li class="py-1">
                    <span class="dropdown-item-text ps-3"><strong class="text-muted">Switch View:</strong> Use the
                      "Month" or "List" buttons to change calendar view</span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div id="calendar" class="p-4"></div>
  
        </div>
      </div>
    </div>

    <div id="satistics" class="container px-0 py-4 mb-3 mt-2">
      <div class="row">
        <div class="col-12">
          <div class="heading">WORKOUT STATISTICS</div>
          <hr style="border-top: 3px solid #000; opacity: 1; margin:0;">
          <div class="row mt-5">
            <div class="col-auto">
              <select class="form-select"
                style="min-width: 150px; background-color: var(--primaryColor); color: var(--text-color-light); background-image: url('data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27white%27 viewBox=%270 0 16 16%27%3E%3Cpath d=%27M1.5 5.5l6 6 6-6%27/%3E%3C/svg%3E');">
                <option selected disabled>Select Year</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
              </select>
            </div>
          </div>
          <div class="row justify-content-center mt-2">
            <!-- Chart 1 Column -->
            <div class="col-lg-6 col-md-10 col-12 d-flex flex-column align-items-center">
              <div class="subheading text-center mt-3 w-100 p-1 card-title"
                style="background-color: var(--primaryColor); color: var(--text-color-light);">WORKOUT TYPE TRACKER
              </div>
              <div class="card rounded-0" style="width: 100%; height: 320px;">
                <div class="card-body d-flex flex-column align-items-center">
                  <canvas id="pieChart" style="width: 100%; height: 280px;"></canvas>
                </div>
              </div>
            </div>

            <!-- Chart 2 Column -->
            <div class="col-lg-6 col-md-10 col-12 d-flex flex-column align-items-center">
              <div class="subheading text-center mt-3 w-100 p-1 card-title"
                style="background-color: var(--primaryColor); color: var(--text-color-light);">MONTHLY WORKOUT FREQUENCY
              </div>
              <div class="card rounded-0" style="width: 100%; height: 320px;">
                <div class="card-body d-flex flex-column align-items-center">
                  <canvas id="barChart" style="width: 100%; height: 300px;"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
  <script src="../assets/js/user.js"></script>
  <script>
    function loadCalendar() {
      const calendarEl = document.getElementById('calendar');
      if (calendarEl) {
        const screenWidth = window.innerWidth;
        const initialView = screenWidth < 768 ? 'listWeek' : 'dayGridMonth';

        const calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: initialView,
          height: 'auto',
          editable: true,
          eventDurationEditable: false,
          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,listWeek'
          },
          events: <?= $eventsJSON ?>,
          dateClick: function (info) {
            document.getElementById('eventStart').value = info.dateStr;
            document.getElementById('eventEnd').value = info.dateStr;
            new bootstrap.Modal(document.getElementById('addWorkoutModal')).show();
          },
          eventClick: function (info) {
            document.getElementById('editWorkoutID').value = info.event.id;
            document.getElementById('editWorkoutStart').value = info.event.startStr.slice(0, 10);
            document.getElementById('editWorkoutEnd').value = info.event.endStr ? info.event.endStr.slice(0, 10) : info.event.startStr.slice(0, 10);
            document.getElementById('editWorkoutColor').value = info.event.backgroundColor;
            const types = info.event.title.split(',').map(t => t.trim());
            const select = document.getElementById('editWorkoutType');
            [...select.options].forEach(opt => opt.selected = types.includes(opt.value));
            selectedEvent = info.event;
            new bootstrap.Modal(document.getElementById('editWorkoutModal')).show();
          },
          eventDrop: function (info) {
            const form = document.createElement('form');
            form.method = 'POST';

            const inputs = [
              ['editWorkoutID', info.event.id],
              ['editWorkoutType', info.event.title],
              ['editWorkoutStart', info.event.startStr],
              ['editWorkoutEnd', info.event.endStr || info.event.startStr],
              ['editWorkoutColor', info.event.backgroundColor],
              ['editWorkout', '1']
            ];

            inputs.forEach(([name, value]) => {
              const input = document.createElement('input');
              input.type = 'hidden';
              input.name = name;
              input.value = value;
              form.appendChild(input);
            });

            document.body.appendChild(form);
            form.submit();
          }
        });
        calendar.render();
      }
    }
    loadCalendar();

    function openDeleteModal() {
      const id = document.getElementById('editWorkoutID').value;
      const deleteModalEl = document.getElementById('deleteWorkoutModal' + id);

      if (deleteModalEl) {
        setTimeout(() => {
          const deleteModal = new bootstrap.Modal(deleteModalEl);
          deleteModal.show();
        }, 300);
      }
    }

    <?php
    $modalID = '';

    if (!empty($showAddModal)) {
      $modalID = 'confirmAddWorkoutModal';
    } elseif (!empty($showEditModal)) {
      $modalID = 'confirmEditWorkoutModal';
    } elseif (!empty($showDeleteModal)) {
      $modalID = 'confirmDeleteWorkoutModal';
    }

    if ($modalID): ?>
      window.addEventListener('DOMContentLoaded', function () {
        new bootstrap.Modal(document.getElementById('<?= $modalID ?>')).show();
      });
    <?php endif; ?>

  </script>

  <!-- Dialogflow Chatbot  -->
  <?php include("views/chatbot.html"); ?>