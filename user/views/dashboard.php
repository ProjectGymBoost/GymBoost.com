<?php
include("../assets/shared/connect.php");

$userID = 1;

// ANNOUNCEMENTS QUERY
$announcementsQuery = "SELECT * FROM announcements ORDER BY announcementID DESC LIMIT 3";
$announcementsResult = executeQuery($announcementsQuery);

// ATTENDANCE QUERY
$attendanceQuery = "SELECT COUNT(*) AS checkInTotal FROM attendances WHERE userID = $userID";
$attendanceResult = executeQuery($attendanceQuery);

// USER_MEMBERSHIP QUERY
$usermembershipQuery = "
SELECT user_memberships.membershipID, user_memberships.endDate, memberships.planType
FROM user_memberships
JOIN memberships ON user_memberships.membershipID = memberships.membershipID
WHERE user_memberships.userID = $userID
";
$usermembershipResult = executeQuery($usermembershipQuery);

?>

<div id="dashboard" class="container">
  <div id="announcement" class="container px-0 py-4 mb-3 mt-2">
    <div class="row">
      <div class="col-12">
        <div class="heading">ANNOUNCEMENT</div>
        <hr style="border-top: 3px solid #000; opacity: 1; margin:0;">
        <div class="container">
          <?php
          if (mysqli_num_rows($announcementsResult) > 0) {
            while ($announcement = mysqli_fetch_assoc($announcementsResult)) {
              ?>
              <div class="row justify-content-center mt-2">
                <div class="col-12 col-md-8 mx-4 my-2">
                  <div class="rounded-box card-bg-color">
                    <?php echo ($announcement['message']); ?>
                  </div>
                </div>
              </div>
              <?php
            }
          } else {
            ?>
            <div class="row justify-content-center mt-2">
              <div class="col-12 col-md-8 mx-4 my-2">
                <div class="rounded-box card-bg-color">
                  No announcements available.
                </div>
              </div>
            </div>
            <?php
          }
          ?>
        </div>
      </div>
    </div>
  </div>

  <div id="engagement" class="container px-0 py-4 mb-3 mt-3">
    <div class="row">
      <div class="col-12">
        <div class="heading">YOUR ENGAGEMENT</div>
        <hr style="border-top: 3px solid #000; opacity: 1; margin:0;">
      </div>
      <div class="row mt-2">

        <?php
        if (mysqli_num_rows($usermembershipResult) > 0) {
          while ($usermembershipData = mysqli_fetch_assoc($usermembershipResult)) {
            ?>
            <div class="col-12 col-md-6">
              <div class="subheading mb-3 mt-2 mx-3">MEMBERSHIP STATUS</div>
              <div class="mt-1 mx-4" style="font-weight:bold">
                Membership Plan
              </div>
              <div class="mx-4 mb-2"><?php echo $usermembershipData['planType']; ?>
              </div>
              <div class="mt-1 mx-4" style="font-weight:bold">
                Expiry Date
              </div>
              <div class="mx-4 mb-2">
                <?php echo $usermembershipData['endDate']; ?>
              </div>
            </div>
            <?php
          }
        }
        ?>

        <div class="col-12 col-md-6">
          <div class="subheading mb-3 mt-2 mx-3">ATTENDANCE HISTORY</div>
          <div class="mt-1 mx-4" style="font-weight:bold">
            Check-ins
          </div>
          <?php
          if (mysqli_num_rows($attendanceResult) > 0) {
            while ($userAttendanceData = mysqli_fetch_assoc($attendanceResult)) {
              ?>
              <div class="mx-4 mb-2">
                <?php echo ($userAttendanceData['checkInTotal']); ?>
              </div>
              <?php
            }
          }
          ?>
          <div class="mt-1 mx-4" style="font-weight:bold">
            Streak
          </div>
          <div class="mx-4 mb-2">
            ?????</div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Dialogflow Chatbot  -->
<?php include("views/chatbot.html"); ?>