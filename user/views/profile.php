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
            <div class="text-center mb-4 mt-4"><img id="profilePreview" src="../assets/img/logo/backupLogo.png"
                alt="Profile Picture" class="rounded-circle mb-3"
                style="width: 230px; height: 230px; object-fit: cover; border: 2px solid #000;">
              <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-3 mt-4 mb-4">
                <button class="btn btn-primary btn-sm px-3 px-md-4 px-lg-3">Update Profile Picture</button>
                <button class="btn btn-primary btn-sm px-3 px-md-4 px-lg-3">Remove Profile Picture</button>
              </div>
            </div>

            <div class="container px-5 mb-4">
              <div class="row">

                <div class="col-12 mb-3 ps-md-4">
                  <div><b>Full Name:</b> John Doe</div>
                </div>

                <div class="col-6 mb-3 ps-md-4">
                  <div><b>Age:</b>21</div>
                </div>
                <div class="col-6 mb-3 ps-md-4">
                  <div><b>Gender:</b>Male</div>
                </div>

                <div class="col-6 mb-3 ps-md-4">
                  <div><b>Weight:</b>85kg</div>
                </div>
                <div class="col-6 mb-3 ps-md-4">
                  <div><b>Height:</b>170cm</div>
                </div>
              </div>
            </div>

            <div class="text-center mt-3 mb-5">
              <button class="btn btn-primary mt-3 mb-2">EDIT PROFILE</button>
            </div>
          </div>
        </div>
      </div>


      <!-- Right Column - Account Settings -->
      <div class="col-12 col-lg-6">
        <div class="card-body p-0 mt-2 d-flex flex-column">

          <!-- QR Code Section -->
          <div class="mb-4">
            <div class="subheading">QR CODE</div>
            <hr style="border-top: 3px solid #000; opacity: 1; margin: 0 0 2rem 0;">
            <div
              class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mt-4 mb-4">
              <div>
                <p class="mb-2 ps-2"><b>Membership Plan:</b></p>
                <p class="mb-2 ps-2"><b>Start Date:</b></p>
                <p class="mb-2 ps-2"><b>End Date:</b></p>
                <button class="btn btn-primary mt-2">Download QR</button>
              </div>
              <img src="https://api.qrserver.com/v1/create-qr-code/?data=https%3A%2F%2Fgithub.com%2FProjectGymBoost%2FGymBoost.com.git&size=160x160" alt="QR Code" class="qr-img rounded-4 border border-dark p-2">
            </div>
          </div>

          <!-- Account Information Section -->
          <div class="mb-4">
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
              <button class="btn btn-primary" type="submit">CHANGE</button>
            </div>

          </div>

          <!-- Delete Account Section -->
          <div class="mb-4">
            <div class="subheading">ACCOUNT DELETION</div>
            <hr style="border-top: 3px solid #000; opacity: 1; margin: 0 0 1rem 0;">
            <div
              class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
              <p class="mb-0">Once deleted, your account can no longer be retrieved.
              </p>
              <button class="btn btn-primary">DELETE</button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>