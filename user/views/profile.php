<?php
$pfpClass = $profileUpdated ? 'border-updated' : 'border-normal';
$isDefaultPic = ($pfpFileName === 'defaultProfile.png');
?>

<div id="profile" class="container">
  <div id="announcement" class="container px-0 py-4 mb-3 mt-2">
    <div class="row">
      <div class="col-12">
        <div class="heading">MY ACCOUNT</div>
        <hr style="border-top: 3px solid #000; opacity: 1; margin:0;">
      </div>
    </div>

    <!-- Main Content -->
    <div class="row g-4 mt-2">
      <!-- Left Column - Profile Section -->
      <div class="col-12 col-lg-6">
        <div class="card profile-card" style="border: 3px solid #000;">
          <div class="card-body p-0 d-flex flex-column">
            <div class="text-center mb-4 mt-5">
              <img id="profilePreview" src="../assets/img/profile/<?php echo $pfpFileName ?>" alt="Profile Picture"
                class="rounded-circle mb-3 <?php echo $pfpClass; ?>"
                style="width: 230px; height: 230px; object-fit: cover;">
              <div
                class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-3 mt-4 mb-4 <?= $isDefaultPic ? 'justify-content-center' : '' ?>">
                <button class="btn btn-primary btn-sm px-3 px-md-4 px-lg-3" data-bs-toggle="modal"
                  data-bs-target="#updateProfilePictureModal">
                  Update Profile Picture
                </button>

                <?php if (!$isDefaultPic): ?>
                  <button class="btn btn-primary btn-sm px-3 px-md-4 px-lg-3" data-bs-toggle="modal"
                    data-bs-target="#removeProfilePictureModal">
                    Remove Profile Picture
                  </button>
                <?php endif; ?>
              </div>

              <?php if (isset($_SESSION['accountUpdated']) && $_SESSION['accountUpdated'] === true): ?>
                <input type="hidden" id="accountUpdatedFlag" value="true">
                <?php unset($_SESSION['accountUpdated']); ?>
              <?php endif; ?>

              <?php if (isset($_SESSION['profileUpdated'])): ?>
                <input type="hidden" id="profileUpdatedFlag" value="true">
                <?php unset($_SESSION['profileUpdated']); ?>
              <?php endif; ?>

              <?php if (isset($_SESSION['profilePicUpdated'])): ?>
                <input type="hidden" id="profilePicUpdatedFlag" value="true">
                <?php unset($_SESSION['profilePicUpdated']); ?>
              <?php endif; ?>

              <?php if (isset($_SESSION['profilePicRemoved'])): ?>
                <input type="hidden" id="profilePicRemovedFlag" value="true">
                <?php unset($_SESSION['profilePicRemoved']); ?>
              <?php endif; ?>

              <?php if (isset($_SESSION['uploadStatus']) && $_SESSION['uploadStatus'] !== 'success'): ?>
                <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 3;">
                  <div class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive"
                    aria-atomic="true">
                    <div class="d-flex">
                      <div class="toast-body">
                        <?php
                        switch ($_SESSION['uploadStatus']) {
                          case 'invalid_type':
                            echo 'Invalid file type. Please upload an image in JPG or PNG format only.';
                            break;
                          case 'file_too_large':
                            echo 'File too large. Please upload an image smaller than 5MB.';
                            break;
                          case 'upload_failed':
                            echo 'Failed to upload image. Please try again.';
                            break;
                          default:
                            echo 'An unknown error occurred during upload.';
                        }
                        ?>
                      </div>
                      <button type="button" class="btn-close btn-close-white me-2 m-auto"
                        data-bs-dismiss="toast"></button>
                    </div>
                  </div>
                </div>
                <?php unset($_SESSION['uploadStatus']); ?>
              <?php endif; ?>
            </div>

            <div class="container px-5 mb-md-4">
              <div class="row px-0 px-lg-1">
                <div class="col-md-6 col-12 mb-3 px-0 px-md-5 px-lg-4 text-center text-md-start">
                  <div><b>First Name:</b> <?php echo $userInfoArray['firstName'] ?? 'N/A'; ?></div>
                </div>
                <div class="col-md-6 col-12 mb-3 px-0 px-md-3 text-center text-md-start">
                  <div><b>Last Name:</b> <?php echo $userInfoArray['lastName'] ?? 'N/A'; ?></div>
                </div>
                <div class="col-md-6 col-12 mb-3 px-0 px-md-5 px-lg-4 text-center text-md-start">
                  <div><b>Age:</b> <?php echo $userInfoArray['age']; ?></div>
                </div>
                <div class="col-md-6 col-12 mb-3 px-0 px-md-3 text-center text-md-start">
                  <div><b>User ID:</b> <?php echo $userInfoArray['userID'] ?? 'N/A'; ?></div>
                </div>
              </div>
            </div>

            <div class="text-center mt-3 mb-5">
              <button class="btn btn-primary mt-3 mb-2" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                EDIT PROFILE
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column - Account Settings -->
      <div class="col-12 col-lg-6">
        <div class="card-body p-0 mt-2 d-flex flex-column">
          <!-- RFID Section -->
          <div class="mb-1 mb-md-3">
            <div class="subheading">RFID CARD</div>
            <hr style="border-top: 3px solid #000; opacity: 1; margin: 0 0 2rem 0;">
            <div
              class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mt-4 mb-4">
              <div>
                <p class="mb-2 ps-2"><b>Membership Plan:</b> <?php echo $userInfoArray['planType'] ?? 'N/A'; ?></p>
                <p class="mb-2 ps-2"><b>Start Date:</b> <?php echo $userInfoArray['startDate'] ?? 'N/A'; ?></p>
                <p class="mb-2 ps-2"><b>End Date:</b> <?php echo $userInfoArray['endDate'] ?? 'N/A'; ?></p>
              </div>
              <div class="rfid-card border border-dark rounded-4 shadow-sm position-relative"
                style="width: 290px; height: 200px; display: flex; justify-content: center; align-items: center; background: white; overflow: hidden; cursor: pointer;"
                data-bs-toggle="modal" data-bs-target="#rfidModal">
                <img src="../assets/img/profile/rfidcard.png" alt="RFID" class="w-100 h-100" style="object-fit: cover;">
                <span class="position-absolute"
                  style="bottom: 10px; right: 10px; color: black; padding: 2px 6px; font-size: 14px;">
                  <?php echo $userInfoArray['rfidNumber'] ?? 'N/A'; ?>
                </span>
              </div>
            </div>
          </div>

          <!-- Account Information Section -->
          <div class="mb-4 mb-md-3 ">
            <div class="subheading">ACCOUNT INFORMATION</div>
            <hr style="border-top: 3px solid #000; opacity: 1; margin: 0 0 1rem 0;">
            <div class="row align-items-center mt-4 mb-3 ps-2">
              <div class="col-4 col-md-2">
                <label class="form-label mb-0"><b>Email</b></label>
              </div>
              <div class="col-8 col-md-10">
                <div class="input-group">
                  <input type="email" class="form-control" name="email" placeholder="Enter email"
                    value="<?php echo $userInfoArray['email'] ?? 'N/A'; ?>"
                    style="font-size: clamp(0.8rem, 2vw, 1.1rem);" disabled>
                  <button class="btn btn-primary btn-responsive-sm" type="button" data-bs-toggle="modal"
                    data-bs-target="#editAccountEmailModal">
                    <i class="bi bi-pencil-square"></i>
                    <span class="d-none d-sm-inline">CHANGE</span>
                  </button>
                </div>
              </div>
            </div>

            <div class="row align-items-center ps-2">
              <div class="col-4 col-md-2">
                <label class="form-label mb-0"><b>Password</b></label>
              </div>
              <div class="col-8 col-md-10">
                <div class="input-group">
                  <input type="password" class="form-control" placeholder="********" name="password"
                    placeholder="Enter password" style="font-size: clamp(0.8rem, 2vw, 1.1rem);" disabled>
                  <button class="btn btn-primary btn-responsive-sm" type="button" data-bs-toggle="modal"
                    data-bs-target="#editAccountPassModal">
                    <i class="bi bi-pencil-square"></i>
                    <span class="d-none d-sm-inline">CHANGE</span>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Delete Account Section -->
          <div class="mb-3">
            <div class="subheading">ACCOUNT DELETION</div>
            <hr style="border-top: 3px solid #000; opacity: 1; margin: 0 0 1rem 0;">
            <div
              class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
              <p class="mb-0">Once deleted, your account can no longer be retrieved.</p>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                DELETE
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>