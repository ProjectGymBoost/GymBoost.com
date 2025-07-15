<?php include("../assets/php/processes/user/dashboard.php"); ?>

<div id="dashboard" class="container">
  <!-- ANNOUNCEMENTS -->
  <div id="announcement" class="container px-0 py-4 mb-3 mt-2">
    <div class="row">
      <div class="col-12">
        <div class="heading">ANNOUNCEMENT</div>
        <hr style="border-top: 3px solid #000; opacity: 1; margin:0;">
        <div class="container">
          <?php if (!empty($announcementsArray)): ?>
            <?php foreach ($announcementsArray as $announcement): ?>
              <div class="row justify-content-center mt-2">
                <div class="col-12 col-md-8 mx-4 mt-2">
                  <div class="rounded-box card-bg-color">
                    <?= $announcement['message']; ?>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="row justify-content-center mt-2">
              <div class="col-12 col-md-8 mx-4 mt-2">
                <div class="rounded-box" style="color:#D2042D; font-weight:bold;">
                  No announcements available.
                </div>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- ENGAGEMENT -->
  <div id="engagement" class="container px-0 py-4 mb-3 mt-3">
    <div class="row">
      <div class="col-12">
        <div class="heading">YOUR ENGAGEMENT</div>
        <hr style="border-top: 3px solid #000; opacity: 1; margin:0;">
      </div>
      <div class="row mt-2">

        <!-- MEMBERSHIP STATUS -->
        <div class="col-12 col-md-6">
          <div class="subheading mb-3 mt-2 mx-3">MEMBERSHIP STATUS</div>
          <?php if (!empty($usermembershipArray)): ?>
            <?php foreach ($usermembershipArray as $usermembershipData): ?>
              <div class="mt-1 mx-4" style="font-weight:bold">Membership Plan</div>
              <div class="mx-4 mb-2"><?= $usermembershipData['planType']; ?></div>
              <div class="mt-1 mx-4" style="font-weight:bold">Expiry Date</div>
              <div class="mx-4 mb-2"><?= $usermembershipData['endDate']; ?></div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="mx-4 mb-2" style="color:#D2042D; font-weight:bold;">No active membership found.</div>
          <?php endif; ?>
        </div>

        <!-- ATTENDANCE & POINTS -->
        <div class="col-12 col-md-6">
          <div class="subheading mb-3 mt-2 mx-3">ATTENDANCE HISTORY</div>

          <!-- Check-ins -->
          <div class="mt-1 mx-4" style="font-weight:bold">Check-ins</div>
          <?php if (!empty($attendanceArray)): ?>
            <?php foreach ($attendanceArray as $userAttendanceData): ?>
              <div class="mx-4 mb-2"><?= $userAttendanceData['checkInTotal']; ?></div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="mx-4 mb-2" style="color:#D2042D; font-weight:bold;">No attendance records found.</div>
          <?php endif; ?>

          <!-- Points -->
          <div class="mt-1 mx-4" style="font-weight:bold">Points</div>
          <?php if (!empty($pointsArray)): ?>
            <?php foreach ($pointsArray as $userPointsData): ?>
              <div class="mx-4 mb-2"><?= $userPointsData['points']; ?></div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="mx-4 mb-2" style="color:#D2042D; font-weight:bold;">No points earned yet.</div>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- Dialogflow Chatbot  -->
<?php include("views/chatbot.html"); ?>