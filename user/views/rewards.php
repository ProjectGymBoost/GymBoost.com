<!-- REWARD -->
<div class="container">
    <div class="container px-0 py-4 mb-3 mt-2">
        <div class="row">
            <div class="col-12">
                <div class="heading">ACHIEVEMENTS</div>
                <hr style="border-top: 3px solid #000; opacity: 1; margin:0;">
                <div class="container-fluid mt-5">
                    <div class="overflow-auto">
                        <div class="badges-container d-flex flex-row flex-nowrap gap-3 py-3 justify-content-center">
                            <!-- Unlocked Achievement -->
                            <a data-bs-toggle="modal" data-bs-target="#rewardUnlockedModal">
                                <div class="card text-center px-3 py-2 rounded-4 card-unlocked">
                                    <span class="badge bg-light text-dark mb-2 w-50 d-flex justify-content-center mx-auto px-5">2/2 Months</span>
                                    <img src="../assets/img/badges/medal.png" class="img-fluid mx-auto medal-locked">
                                </div>
                            </a>

                            <a data-bs-toggle="modal" data-bs-target="#rewardUnlocked2Modal">
                                <div class="card text-center px-3 py-2 rounded-4 card-unlocked">
                                    <span class="badge bg-light text-dark mb-2 w-50 d-flex justify-content-center mx-auto px-5">4/4 Months</span>
                                    <img src="../assets/img/badges/medal.png" class="img-fluid mx-auto medal-locked">
                                </div>
                            </a>

                            <!-- Locked Achievement -->
                            <a data-bs-toggle="modal" data-bs-target="#rewardLockedModal">
                                <div class="card text-center px-3 py-2 rounded-4 card-locked">
                                    <span class="badge bg-dark text-white mb-2 w-50 d-flex justify-content-center mx-auto px-5">0/6</span>
                                    <img src="../assets/img/badges/medal-locked.png" class="img-fluid mx-auto medal-unlocked">
                                </div>
                            </a>

                            <a data-bs-toggle="modal" data-bs-target="#rewardLocked2Modal">
                                <div class="card text-center px-3 py-2 rounded-4 card-locked">
                                    <span class="badge bg-dark text-white mb-2 w-50 d-flex justify-content-center mx-auto px-5">0/8</span>
                                    <img src="../assets/img/badges/medal-locked.png" class="img-fluid mx-auto medal-unlocked">
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BADGES -->
    <div class="container px-0 py-4 mb-3 mt-2">
        <div class="row">
            <div class="col-12">
                <div class="heading">BADGES</div>
                <hr class="border-3 border-dark opacity-100 m-0">

                <div class="overflow-auto px-2 mt-5">
                    <div class="d-flex flex-nowrap justify-content-center gap-5 py-3 min-scroll-width">

                        <!-- Unlocked Badge -->
                        <div class="card text-center px-3 py-3 text-white rounded-4 bg-container badge-card">
                            <img src="../assets/img/badges/starter.png" class="img-fluid mx-auto mb-2 badge-image">
                            <div class="fw-semibold fs-5">First gym<br>check-in</div>
                        </div>

                        <!-- Unlocked Badge -->
                        <div class="card text-center px-3 py-3 text-white rounded-4 bg-container badge-card">
                            <img src="../assets/img/badges/weekly.png" class="img-fluid mx-auto mb-2 badge-image">
                            <div class="fw-semibold fs-5">Checked-in for<br>7 days in total</div>
                        </div>

                        <!-- Unlocked Badge -->
                        <div class="card text-center px-3 py-3 text-white rounded-4 bg-container badge-card">
                            <img src="../assets/img/badges/monthly.png" class="img-fluid mx-auto mb-2 badge-image">
                            <div class="fw-semibold fs-5">Attended<br>20 sessions</div>
                        </div>

                        <!-- Locked Badge -->
                        <div class="card text-center px-3 py-3 text-white rounded-4 bg-container badge-card locked">
                            <img src="../assets/img/badges/3months.png" class="img-fluid mx-auto mb-2 badge-image">
                            <div class="fw-semibold fs-5">Active for<br>3 months straight</div>
                            <i class="bi bi-lock-fill position-absolute top-0 end-0 m-2 text-white opacity-75"></i>
                        </div>

                        <!-- Locked Badge -->
                        <div class="card text-center px-3 py-3 text-white rounded-4 bg-container badge-card locked">
                            <img src="../assets/img/badges/6month.png" class="img-fluid mx-auto mb-2 badge-image">
                            <div class="fw-semibold fs-5">Active for<br>6 months straight</div>
                            <i class="bi bi-lock-fill position-absolute top-0 end-0 m-2 text-white opacity-75"></i>
                        </div>

                        <!-- Locked Badge -->
                        <div class="card text-center px-3 py-3 text-white rounded-4 bg-container badge-card locked">
                            <img src="../assets/img/badges/loyalty.png" class="img-fluid mx-auto mb-2 badge-image">
                            <div class="fw-semibold fs-5">Logged<br>50 workouts</div>
                            <i class="bi bi-lock-fill position-absolute top-0 end-0 m-2 text-white opacity-75"></i>
                        </div>

                        <!-- Locked Badge -->
                        <div class="card text-center px-3 py-3 text-white rounded-4 bg-container badge-card locked">
                            <img src="../assets/img/badges/master.png" class="img-fluid mx-auto mb-2 badge-image">
                            <div class="fw-semibold fs-5">Member for<br>1 year</div>
                            <i class="bi bi-lock-fill position-absolute top-0 end-0 m-2 text-white opacity-75"></i>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- COMMUNITY LEADERBOARD -->
    <div class="heading mt-5">COMMUNITY LEADERBOARD</div>
    <hr style="border-top: 3px solid #000; opacity: 1; margin:0;">
    <div class="container my-5 px-0">
        <div class="bg-container text-white p-3 p-md-5 rounded-4">
            <!-- Filter -->
            <div class="row row-cols-1 row-cols-md-3 g-2 g-md-5 mb-4 mb-md-5 mx-0">
                <div class="col px-1">
                    <button class="btn btn-light rounded-pill px-2 px-md-4 fw-bold w-100">WEEKLY</button>
                </div>
                <div class="col px-1">
                    <button class="btn btn-light rounded-pill px-2 px-md-4 fw-bold w-100">MONTHLY</button>
                </div>
                <div class="col px-1">
                    <button class="btn btn-light rounded-pill px-2 px-md-4 fw-bold w-100">ALL TIME</button>
                </div>
            </div>

            <!-- Leaderboard Header -->
            <div class="d-flex subheading fs-6 bg-secondary text-white px-2 py-3 rounded-3 mb-2 mx-0">
                <div class="col-3 col-sm-2 fw-bold ps-1">Rank</div>
                <div class="col fw-bold ps-2">Name</div>
                <div class="col-3 col-sm-2 fw-bold text-end pe-1">Points</div>
            </div>

            <!-- Leaderboard Items -->
            <div class="bg-light text-dark d-flex align-items-center px-2 py-4 rounded-3 mb-2 mx-0">
                <div class="col-3 col-sm-2">
                    <span class="badge bg-warning p-2 px-sm-3 fw-bold">1</span>
                </div>
                <div class="col fw-semibold ps-2 text-truncate">John Doe</div>
                <div class="col-3 col-sm-2 text-end fw-bold pe-1">1500</div>
            </div>

            <div class="bg-light text-dark d-flex align-items-center px-2 py-4 rounded-3 mb-2 mx-0">
                <div class="col-3 col-sm-2">
                    <span class="badge bg-secondary p-2 px-sm-3 fw-bold">2</span>
                </div>
                <div class="col fw-semibold ps-2 text-truncate">Jane Smith</div>
                <div class="col-3 col-sm-2 text-end fw-bold pe-1">1400</div>
            </div>

            <div class="bg-light text-dark d-flex align-items-center px-2 py-4 rounded-3 mb-2 mx-0">
                <div class="col-3 col-sm-2">
                    <span class="badge bg-orange text-white p-2 px-sm-3 fw-bold">4</span>
                </div>
                <div class="col fw-semibold ps-2 text-truncate">John Lloyd Cruz</div>
                <div class="col-3 col-sm-2 text-end fw-bold pe-1">1300</div>
            </div>

            <div class="bg-light text-dark d-flex align-items-center px-2 py-4 rounded-3 mb-2 mx-0">
                <div class="col-3 col-sm-2">
                    <span class="badge border border-dark p-2 px-sm-3 fw-bold text-dark">5</span>
                </div>
                <div class="col fw-semibold ps-2 text-truncate">LeBron James</div>
                <div class="col-3 col-sm-2 text-end fw-bold pe-1">1200</div>
            </div>

            <div class="bg-light text-dark d-flex align-items-center px-2 py-4 rounded-3 mb-4 mx-0">
                <div class="col-3 col-sm-2">
                    <span class="badge border border-dark p-2 px-sm-3 fw-bold text-dark">6</span>
                </div>
                <div class="col fw-semibold ps-2 text-truncate">You</div>
                <div class="col-3 col-sm-2 text-end fw-bold pe-1">1100</div>
            </div>

            <!-- Your Rank -->
            <div class="text-center text-white fw-bold text-uppercase mt-4 mt-md-5 mb-3 mb-md-4">Your Current Ranking</div>
            <div class="bg-light text-dark d-flex align-items-center px-2 py-4 rounded-3 mb-3 mx-0">
                <div class="col-3 col-sm-2">
                    <span class="badge border border-dark p-2 px-sm-3 fw-bold text-dark">6</span>
                </div>
                <div class="col fw-semibold ps-2 text-truncate">You</div>
                <div class="col-3 col-sm-2 text-end fw-bold pe-1">1100</div>
            </div>
        </div>
    </div>
</div>

<!-- Claim rewards 2 months modal -->
<div class="modal fade" id="rewardUnlockedModal" tabindex="-1"
    aria-labelledby="rewardUnlockedModalLabel" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <!-- Header -->
            <div
                style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                <h4 class="modal-title text-center subheading" id="rewardUnlockedModalLabel"
                    style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                    REWARD UNLOCKED!
                </h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"
                    style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;"></button>
            </div>

            <!-- Body -->
            <div class="modal-body text-center" style="padding: 1.5rem;">
                <p style="margin: 0; font-size: 16px; color: black;">
                    You've successfully completed 2 months of active membership.
                    You are now eligible to claim your <b>Free Hand Grip</b>.
                    Please proceed to the front desk to receive your reward.
                </p>
            </div>

            <!-- Footer -->
            <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    CANCEL
                </button>
                <button type="button" class="btn btn-primary" style="margin-left: 0.5rem;"
                    data-bs-toggle="modal" data-bs-target="#confirmrewardUnlockedModal"
                    data-bs-dismiss="modal">
                    CLAIM
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Confirm claim rewards 2 months modal -->
<div class="modal fade" id="confirmrewardUnlockedModal" tabindex="-1"
    aria-labelledby="confirmrewardUnlockedModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
            <div class="modal-header" style="border: none;">
                <h4 class="modal-title heading text-center w-100 text-black"
                    id="confirmDeleteMembershipModalLabel" style="margin: 0;">
                    REWARD CLAIMED
                </h4>
            </div>
            <div class="modal-body text-center text-black">
                Claim your reward in the gym counter.
            </div>
            <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                    CLOSE
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Claim rewards 4 months modal -->
<div class="modal fade" id="rewardUnlocked2Modal" tabindex="-1"
    aria-labelledby="rewardUnlockedModal2Label" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <!-- Header -->
            <div
                style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                <h4 class="modal-title text-center subheading" id="rewardUnlockedModal2Label"
                    style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                    REWARD UNLOCKED!
                </h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"
                    style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;"></button>
            </div>

            <!-- Body -->
            <div class="modal-body text-center" style="padding: 1.5rem;">
                <p style="margin: 0; font-size: 16px; color: black;">
                    You've successfully completed 4 months of active membership.
                    You are now eligible to claim your <b>Free Waist Support/ Shaker/ Tumbler</b>.
                    Please proceed to the front desk to receive your reward.
                </p>
            </div>

            <!-- Footer -->
            <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    CANCEL
                </button>
                <button type="button" class="btn btn-primary" style="margin-left: 0.5rem;"
                    data-bs-toggle="modal" data-bs-target="#confirmrewardUnlockedModal"
                    data-bs-dismiss="modal">
                    CLAIM
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Confirm claim 4 months rewards modal -->
<div class="modal fade" id="confirmrewardUnlocked2Modal" tabindex="-1"
    aria-labelledby="confirmrewardUnlocked2Modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; color: white; border: none;">
            <div class="modal-header" style="border: none;">
                <h4 class="modal-title heading text-center w-100 text-black"
                    id="confirmDeleteMembershipModalLabel" style="margin: 0;">
                    REWARD CLAIMED
                </h4>
            </div>
            <div class="modal-body text-center text-black">
                Claim your reward in the gym counter.
            </div>
            <div class="modal-footer d-flex justify-content-center pb-4" style="border: none;">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                    CLOSE
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Reward locked 6 months modal -->
<div class="modal fade" id="rewardLockedModal" tabindex="-1"
    aria-labelledby="rewardLockedModalLabel" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <!-- Header -->
            <div
                style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                <h4 class="modal-title text-center subheading" id="rewardLockedModalLabel"
                    style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                    REWARD LOCKED!
                </h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"
                    style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;"></button>
            </div>

            <!-- Body -->
            <div class="modal-body text-center mt-4" style="padding: 1.5rem;">
                <p style="margin: 0; font-size: 16px; color: black;">
                    Subscribe for <b>6 months</b> to unlock a <b>Free Weightlifting Support/ Shaker/ Tumbler + amino.</b><br>
                    Keep it up!
                </p>
            </div>

            <!-- Footer -->
            <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    CANCEL
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Reward locked 8 months modal -->
<div class="modal fade" id="rewardLocked2Modal" tabindex="-1"
    aria-labelledby="rewardLockedModal2Label" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <!-- Header -->
            <div
                style="background-color: var(--primaryColor); color: white; padding: 1rem; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                <h4 class="modal-title text-center subheading" id="rewardLockedModal2Label"
                    style="margin: 0; font-size: 20px; letter-spacing: 2px;">
                    REWARD LOCKED
                </h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"
                    style="position: absolute; top: 16px; right: 16px; background-color: transparent; opacity: 1; outline: none; box-shadow: none;"></button>
            </div>

            <!-- Body -->
            <div class="modal-body text-center mt-4" style="padding: 1.5rem;">
                <p style="margin: 0; font-size: 16px; color: black;">
                    Subscribe for <b>8 months</b> to unlock a <b>Free 1 Month + Sando/ Shaker/ Tumbler.</b><br>
                    Keep it up!
                </p>
            </div>

            <!-- Footer -->
            <div class="modal-footer d-flex justify-content-end" style="border: none; padding: 1rem;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    CANCEL
                </button>
            </div>
        </div>
    </div>
</div>


<!-- Dialogflow Chatbot -->
<?php include("views/chatbot.html"); ?>