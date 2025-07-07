<div id="progile" class="container">
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
            <div class="text-center mb-4 mt-5"><img id="profilePreview" src="../assets/img/profile/defaultProfile.png"
                alt="Profile Picture" class="rounded-circle mb-3"
                style="width: 230px; height: 230px; object-fit: cover; border: 2px solid #000;">
              <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-3 mt-4 mb-4">
                <button class="btn btn-primary btn-sm px-3 px-md-4 px-lg-3" data-bs-toggle="modal"
                  data-bs-target="#updateProfilePictureModal">Update Profile Picture</button>
                <button class="btn btn-primary btn-sm px-3 px-md-4 px-lg-3" data-bs-toggle="modal"
                  data-bs-target="#removeProfilePictureModal">Remove Profile Picture</button>
              </div>

              <!-- Update Profile Picture Modal -->
              <div class="modal fade" id="updateProfilePictureModal" tabindex="-1"
                aria-labelledby="updateProfileModalLabel" aria-hidden="true" data-bs-backdrop="static"
                data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content" style="border-radius: 15px;">
                    <!-- Header -->
                    <div
                      style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                      <h4 class="modal-title text-center subheading" id="updateProfileModalLabel"
                        style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                        UPDATE PROFILE PICTURE
                      </h4>
                      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                        style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;">
                      </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                      <form id="updateProfilePictureModal" enctype="multipart/form-data" method="POST">
                        <div class="d-flex flex-column align-items-center gap-3">

                          <!-- Profile Preview -->
                          <div class="text-center">
                            <div class="rounded-circle overflow-hidden bg-black" style="width: 120px; height: 120px;">
                              <img id="profilePreview2" src="../assets/img/profile/defaultProfile.png"
                                alt="Current Photo" class="w-100 h-100" style="object-fit: cover;">
                            </div>
                          </div>

                          <!-- File Input -->
                          <div class="d-flex align-items-center justify-content-center"
                            style="max-width: 350px; width: 100%;">
                            <input type="text" id="fileNameDisplay"
                              class="form-control text-black bg-transparent rounded-0 rounded-start" value="" readonly>
                            <label
                              class="btn btn-primary rounded-0 rounded-end d-inline-flex align-items-center justify-content-center mb-0"
                              for="fileInput" style="height: 100%;">
                              Browse <i class="bi bi-upload ms-2"></i>
                            </label>
                            <input type="file" class="d-none" id="fileInput" accept="image/*" name="profilePic">
                          </div>
                        </div>
                      </form>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        CANCEL
                      </button>
                      <button type="button" class="btn btn-primary" style="margin-left: 0.5rem;" data-bs-toggle="modal"
                        data-bs-target="#confirmUpdateProfilePicModal">
                        SAVE CHANGES
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Confirm Update Profile Pic Modal -->
              <div class="modal fade" id="confirmUpdateProfilePicModal" tabindex="-1"
                aria-labelledby="confirmUpdateProfilePicLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
                    <div class="modal-header" style="border: none;">
                      <h4 class="modal-title heading text-center w-100 text-black"
                        id="confirmUpdateProfilePicModalLabel" style="margin: 0;">
                        PROFILE PICTURE UPDATED
                      </h4>
                    </div>
                    <div class="modal-body text-center text-black">
                      Your profile picture has been successfully updated.
                    </div>
                    <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                      <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                        CLOSE
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Remove Profile Picture Modal -->
              <div class="modal fade" id="removeProfilePictureModal" tabindex="-1"
                aria-labelledby="removeProfilePictureModalLabel" aria-hidden="true" data-bs-backdrop="static"
                data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content" style="border-radius: 15px;">
                    <!-- Header -->
                    <div
                      style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                      <h4 class="modal-title text-center subheading" id="removeProfilePictureModalLabel"
                        style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                        REMOVE PROFILE PICTURE
                      </h4>
                      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                        style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body text-center" style="padding: 1.5rem;">
                      <p style="margin: 0; font-size: 16px; color: black;">
                        Are you sure you want to remove your profile picture? <br><br>If yes, your profile will be set
                        to our default picture.
                      </p>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        CANCEL
                      </button>
                      <button type="button" class="btn btn-primary" style="margin-left: 0.5rem;" data-bs-toggle="modal"
                        data-bs-target="#confirmRemoveProfilePictureModal" data-bs-dismiss="modal">
                        REMOVE
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Confirm Delete Account Modal -->
              <div class="modal fade" id="confirmRemoveProfilePictureModal" tabindex="-1"
                aria-labelledby="confirmRemoveProfilePictureModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
                    <div class="modal-header" style="border: none;">
                      <h4 class="modal-title heading text-center w-100 text-black"
                        id="confirmRemoveProfilePictureModalLabel" style="margin: 0;">
                        PROFILE PICTURE REMOVED
                      </h4>
                    </div>
                    <div class="modal-body text-center text-black">
                      Your profile picture has been set to the default.
                    </div>
                    <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                      <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                        CLOSE
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="container px-5 mb-md-4">
              <div class="row px-0 px-lg-1">

                <div class="col-md-6 col-6 mb-3 px-0 px-md-5 px-lg-4">
                  <div><b>First Name:</b> John</div>
                </div>

                <div class="col-md-6 col-6 mb-3 px-0 px-md-3 text-end text-md-start">
                  <div><b>Last Name:</b>Doe</div>
                </div>

                <div class="col-md-6 col-6 mb-3 px-0 px-md-5 px-lg-4">
                  <div><b>Age:</b>21</div>
                </div>
              </div>
            </div>

            <div class="text-center mt-3 mb-5">
              <button class="btn btn-primary mt-3 mb-2" data-bs-toggle="modal" data-bs-target="#editProfileModal">EDIT
                PROFILE</button>
            </div>

            <!-- Edit Profile Modal -->
            <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel"
              aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 15px;">
                  <!-- Header -->
                  <div
                    style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                    <h4 class="modal-title text-center subheading" id="editProfileModalLabel"
                      style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                      EDIT PROFILE
                    </h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                      style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;">
                    </button>
                  </div>

                  <!-- Body -->
                  <div class="modal-body" style="padding: 1.5rem;">
                    <form id="editProfileForm">
                      <div class="row">
                        <div class="col-md-6 mb-3 text-start">
                          <label for="FirstName" class="form-label fw-bold">First Name</label>
                          <input type="text" class="form-control" id="FirstName" value="John">
                        </div>
                        <div class="col-md-6 mb-3 text-start">
                          <label for="LastName" class="form-label fw-bold">Last Name</label>
                          <input type="text" class="form-control" id="LastName" value="Doe">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6 mb-3 text-start">
                          <label for="Age" class="form-label fw-bold">Age</label>
                          <input type="text" class="form-control" id="Age" value="21">
                        </div>
                      </div>
                    </form>
                  </div>

                  <!-- Footer -->
                  <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                      CANCEL
                    </button>
                    <button type="button" class="btn btn-primary" style="margin-left: 0.5rem;" data-bs-toggle="modal"
                      data-bs-target="#confirmEditProfileModal">
                      SAVE CHANGES
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Confirm Edit Reward Modal -->
            <div class="modal fade" id="confirmEditProfileModal" tabindex="-1" aria-labelledby="confirmEditProfileLabel"
              aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
                  <div class="modal-header" style="border: none;">
                    <h4 class="modal-title heading text-center w-100 text-black" id="confirmEditProfileModalLabel"
                      style="margin: 0;">
                      PROFILE UPDATED
                    </h4>
                  </div>
                  <div class="modal-body text-center text-black">
                    Your profile has been successfully edited.
                  </div>
                  <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                      CLOSE
                    </button>
                  </div>
                </div>
              </div>
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
                <p class="mb-2 ps-2"><b>Membership Plan:</b></p>
                <p class="mb-2 ps-2"><b>Start Date:</b></p>
                <p class="mb-2 ps-2"><b>End Date:</b></p>
              </div>
              <!-- RFID Card -->
              <div class="rfid-card border border-dark rounded-4 shadow-sm"
                style="width: 290px; height: 200px; display: flex; justify-content: center; align-items: center; background: white; overflow: hidden; cursor: pointer;"
                data-bs-toggle="modal" data-bs-target="#rfidModal">
                <img src="../assets/img/profile/rfid.png" alt="RFID"
                  style="width: 100%; height: 100%; object-fit: cover;">
              </div>
              <!-- RFID Modal -->
              <div class="modal fade" id="rfidModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-body p-0">
                      <img src="../assets/img/profile/rfid.png" alt="RFID Full" class="img-fluid rounded-4">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Account Information Section -->
          <div class="mb-4 mb-md-3 ">
            <div class="subheading">ACCOUNT INFORMATION</div>
            <hr style="border-top: 3px solid #000; opacity: 1; margin: 0 0 1rem 0;">

            <!-- Email Row -->
            <div class="row align-items-center mt-4 mb-3 ps-2">
              <div class="col-4 col-md-2">
                <label class="form-label mb-0"><b>Email</b></label>
              </div>
              <div class="col-8 col-md-10">
                <input type="email" class="form-control" name="email" placeholder="Enter email"
                  value="john@example.com">
              </div>
            </div>

            <!-- Password Row -->
            <div class="row align-items-center ps-2">
              <div class="col-4 col-md-2">
                <label class="form-label mb-0"><b>Password</b></label>
              </div>
              <div class="col-8 col-md-10">
                <input type="password" class="form-control" name="password" placeholder="Enter password">
              </div>
            </div>

            <div class="text-start text-md-end mt-3">
              <button class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#editAccountInfoModal">CHANGE</button>
            </div>

            <!-- Edit Account Information Modal -->
            <div class="modal fade" id="editAccountInfoModal" tabindex="-1" aria-labelledby="editAccountInfoModalLabel"
              aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 15px;">
                  <!-- Header -->
                  <div
                    style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                    <h4 class="modal-title text-center subheading" id="editAccountInfoModalLabel"
                      style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                      EDIT ACCOUNT INFORMATION
                    </h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                      style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;">
                    </button>
                  </div>

                  <!-- Body -->
                  <div class="modal-body" style="padding: 1.5rem;">
                    <form id="editAccountInfoForm">
                      <div class="mb-3 text-start">
                        <label for="Email" class="form-label fw-bold">Email</label>
                        <input type="text" class="form-control" id="Email" value="">
                      </div>
                      <div class="mb-3 text-start">
                        <label for="CurrentPassowrd" class="form-label fw-bold">Current Password</label>
                        <input type="text" class="form-control" id="CurrentPassowrd" value="">
                      </div>
                      <div class="mb-3 text-start">
                        <label for="New Passowrd" class="form-label fw-bold">New Password</label>
                        <input type="text" class="form-control" id="NewPassowrd" value="">
                      </div>
                      <div class="mb-3 text-start">
                        <label for="ConfirmPassowrd" class="form-label fw-bold">Confirm Password</label>
                        <input type="text" class="form-control" id="ConfirmPassowrd" value="">
                      </div>
                    </form>
                  </div>

                  <!-- Footer -->
                  <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                      CANCEL
                    </button>
                    <button type="button" class="btn btn-primary" style="margin-left: 0.5rem;" data-bs-toggle="modal"
                      data-bs-target="#confirmEditAccountInfoModal">
                      SAVE CHANGES
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Confirm Edit Account Information Modal -->
            <div class="modal fade" id="confirmEditAccountInfoModal" tabindex="-1"
              aria-labelledby="confirmEditAccountInfoLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
                  <div class="modal-header" style="border: none;">
                    <h4 class="modal-title heading text-center w-100 text-black" id="confirmEditAccountInfoModalLabel"
                      style="margin: 0;">
                      ACCOUNT INFORMATION UPDATED
                    </h4>
                  </div>
                  <div class="modal-body text-center text-black">
                    Your account information has been successfully updated.
                  </div>
                  <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                      CLOSE
                    </button>
                  </div>
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
              <p class="mb-0">Once deleted, your account can no longer be retrieved.
              </p>
              <button class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#deleteAccountModal">DELETE</button>
            </div>
          </div>

          <!-- Delete Account Modal -->
          <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel"
            aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content" style="border-radius: 15px;">
                <!-- Header -->
                <div
                  style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                  <h4 class="modal-title text-center subheading" id="deleteAccountModalLabel"
                    style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                    DELETE ACCOUNT
                  </h4>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                    style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;"></button>
                </div>

                <!-- Body -->
                <div class="modal-body text-center" style="padding: 1.5rem;">
                  <p style="margin: 0; font-size: 16px; color: black;">
                    Are you sure you want to delete this account? <br><br>If you decided to delete your account, all
                    data related to it will also be deleted.
                  </p>
                </div>

                <!-- Footer -->
                <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    CANCEL
                  </button>
                  <button type="button" class="btn btn-primary" style="margin-left: 0.5rem;" data-bs-toggle="modal"
                    data-bs-target="#confirmdeleteAccountModal" data-bs-dismiss="modal">
                    DELETE
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Confirm Delete Account Modal -->
          <div class="modal fade" id="confirmdeleteAccountModal" tabindex="-1"
            aria-labelledby="confirmDeleteAccountModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
                <div class="modal-header" style="border: none;">
                  <h4 class="modal-title heading text-center w-100 text-black" id="confirmDeleteAccountModalLabel"
                    style="margin: 0;">
                    ACCOUNT DELETED
                  </h4>
                </div>
                <div class="modal-body text-center text-black">
                  This account has been successfully deleted. You have been logged out and will be redirected to the
                  login page.
                </div>
                <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                  <a href="../login.php" class="btn btn-primary" role="button">
                    CLOSE
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>