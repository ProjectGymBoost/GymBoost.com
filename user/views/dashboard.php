<div id="dashboard" class="container">
  <div id="announcement" class="container px-0 py-4 mb-3 mt-2">
    <div class="row">
      <div class="col-12">
        <div class="heading mb-3">ANNOUNCEMENT</div>
        <hr style="border-top: 3px solid #000; opacity: 1;">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-12 col-md-8 mx-4 my-2">
              <div class="rounded-box">
                “Gym closed on April 20 for maintenance.”
              </div>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="col-12 col-md-8 mx-4 my-2">
              <div class="rounded-box">
                “New Yoga Class starts April 15.”
              </div>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="col-12 col-md-8  mx-4 my-2">
              <div class="rounded-box">
                “Gym closed on April 24 for maintenance.”
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="engagement" class="container px-0 py-4 mb-3 mt-3">
    <div class="row">
      <div class="col-12">
        <div class="heading mb-3">YOUR ENGAGEMENT</div>
        <hr style="border-top: 3px solid #000; opacity: 1;">
      </div>
      <div class="row">
        <div class="col-12 col-md-6">
          <div class="subheading mb-3 mt-2 mx-3">MEMBERSHIP STATUS</div>
          <div class="mt-1 mx-4" style="font-weight:bold">
            Membership Plan
          </div>
          <div class="mx-4 mb-2">Gold
          </div>
          <div class="mt-1 mx-4" style="font-weight:bold">
            Expiry Date
          </div>
          <div class="mx-4 mb-2">
            2025-04-30</div>
        </div>
        <div class="col-12 col-md-6">
          <div class="subheading mb-3 mt-2 mx-3">ATTENDANCE HISTORY</div>
          <div class="mt-1 mx-4" style="font-weight:bold">
            Check-ins
          </div>
          <div class="mx-4 mb-2">
            23</div>
          <div class="mt-1 mx-4" style="font-weight:bold">
            Streak
          </div>
          <div class="mx-4 mb-2">
            5</div>
        </div>
      </div>
    </div>
  </div>

  <div id="aichat-container">
    <div id="aichat-button" onclick="toggleChat()">
      <img src=".././assets/img/logo/officialLogo.png" alt="Chat Icon">
    </div>

    <!-- tab -->
    <div id="chat-tab">
      <div class="chat-body">
      </div>
    </div>
  </div>

</div>

<script>
  function toggleChat() {
  const chatTab = document.getElementById("chat-tab");
  chatTab.classList.toggle("open"); 
}

</script>