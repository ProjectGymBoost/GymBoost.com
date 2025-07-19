<?php include("../assets/php/processes/user/achievements.php"); ?>

<!-- ACHIEVEMENTS -->
<div class="container">

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
                            <div class="fw-semibold">First gym<br>check-in</div>
                        </div>

                        <!-- Unlocked Badge -->
                        <div class="card text-center px-3 py-3 text-white rounded-4 bg-container badge-card">
                            <img src="../assets/img/badges/weekly.png" class="img-fluid mx-auto mb-2 badge-image">
                            <div class="fw-bold">Checked-in for<br>7 days in total</div>
                        </div>

                        <!-- Unlocked Badge -->
                        <div class="card text-center px-3 py-3 text-white rounded-4 bg-container badge-card">
                            <img src="../assets/img/badges/monthly.png" class="img-fluid mx-auto mb-2 badge-image">
                            <div class="fw-bold">Attended<br>20 sessions</div>
                        </div>

                        <!-- Locked Badge -->
                        <div class="card text-center px-3 py-3 text-white rounded-4 bg-container badge-card locked">
                            <img src="../assets/img/badges/3months.png" class="img-fluid mx-auto mb-2 badge-image">
                            <div class="fw-bold text-muted">Active for<br>3 months straight</div>
                            <i class="bi bi-lock-fill position-absolute top-0 end-0 m-2 text-white opacity-75"></i>
                        </div>

                        <!-- Locked Badge -->
                        <div class="card text-center px-3 py-3 text-white rounded-4 bg-container badge-card locked">
                            <img src="../assets/img/badges/6month.png" class="img-fluid mx-auto mb-2 badge-image">
                            <div class="fw-bold text-muted">Active for<br>6 months straight</div>
                            <i class="bi bi-lock-fill position-absolute top-0 end-0 m-2 text-white opacity-75"></i>
                        </div>

                        <!-- Locked Badge -->
                        <div class="card text-center px-3 py-3 text-white rounded-4 bg-container badge-card locked">
                            <img src="../assets/img/badges/loyalty.png" class="img-fluid mx-auto mb-2 badge-image">
                            <div class="fw-bold text-muted">Logged<br>50 workouts</div>
                            <i class="bi bi-lock-fill position-absolute top-0 end-0 m-2 text-white opacity-75"></i>
                        </div>

                        <!-- Locked Badge -->
                        <div class="card text-center px-3 py-3 text-white rounded-4 bg-container badge-card locked">
                            <img src="../assets/img/badges/master.png" class="img-fluid mx-auto mb-2 badge-image">
                            <div class="fw-bold text-muted">Member for<br>1 year</div>
                            <i class="bi bi-lock-fill position-absolute top-0 end-0 m-2 text-white opacity-75"></i>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- COMMUNITY LEADERBOARD -->
    <div id="leaderboard" class="heading mt-5">COMMUNITY LEADERBOARD</div>
    <hr style="border-top: 3px solid #000; opacity: 1; margin:0;">
    <div class="container my-5 px-0">
        <div class="bg-container text-white p-3 p-md-5 rounded-4">

            <!-- Filter -->
            <div class="row row-cols-1 row-cols-md-3 g-2 g-md-5 mb-4 mb-md-5 mx-0">
                <div class="col px-1">
                    <a href="<?= $baseURL ?>&filter=weekly#leaderboard"
                        class="btn rounded-pill px-2 px-md-4 fw-bold w-100 <?= $filter === 'weekly' ? 'bg-white text-dark' : 'text-white' ?>"
                        style="border: 2px solid white;">
                        WEEKLY
                    </a>
                </div>
                <div class="col px-1">
                    <a href="<?= $baseURL ?>&filter=monthly#leaderboard"
                        class="btn rounded-pill px-2 px-md-4 fw-bold w-100 <?= $filter === 'monthly' ? 'bg-white text-dark' : 'text-white' ?>"
                        style="border: 2px solid white;">
                        MONTHLY
                    </a>
                </div>
                <div class="col px-1">
                    <a href="<?= $baseURL ?>&filter=all#leaderboard"
                        class="btn rounded-pill px-2 px-md-4 fw-bold w-100 <?= $filter === 'all' ? 'bg-white text-dark' : 'text-white' ?>"
                        style="border: 2px solid white;">
                        ALL TIME
                    </a>
                </div>
            </div>

            <!-- Leaderboard Header -->
            <div class="d-flex fs-6 bg-secondary text-white px-2 py-2 py-lg-3 rounded-3 mb-2 mx-0">
                <div class="col-3 col-sm-2 fw-bold ps-1">RANK</div>
                <div class="col fw-bold ps-2">NAME</div>
                <div class="col-3 col-sm-2 fw-bold text-end pe-1">POINTS</div>
            </div>

            <!-- Leaderboard Items -->
            <?php foreach ($leaderboard as $entry): ?>
                <?php
                $badgeClass = 'border border-dark text-dark';
                if ($entry['rank'] === 1)
                    $badgeClass = 'bg-warning text-dark';
                elseif ($entry['rank'] === 2)
                    $badgeClass = 'bg-secondary text-white';
                elseif ($entry['rank'] === 3)
                    $badgeClass = 'bg-orange text-white';
                ?>
                <div class="bg-light text-dark d-flex align-items-center px-2 py-2 py-lg-3 rounded-3 mb-2 mx-0">
                    <div class="col-3 col-sm-2">
                        <span class="badge <?php echo $badgeClass; ?> py-2 py-lg-3 px-3 fw-bold">
                            <?php echo $entry['rank']; ?>
                        </span>
                    </div>
                    <div class="col ps-2 fw-semibold text-truncate">
                        <?php echo htmlspecialchars($entry['username']); ?>
                    </div>
                    <div class="col-3 col-sm-2 fw-bold text-end pe-1">
                        <?php echo $entry['points']; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if ($yourRank !== null): ?>
                <div class="text-center text-white fw-bold text-uppercase mt-4 mt-md-5 mb-3 mb-md-4">
                    Your Current Ranking
                </div>

                <?php
                $rankBadgeClass = 'border border-dark text-dark';
                $rankInt = (int) $yourRank;

                if ($rankInt === 1) {
                    $rankBadgeClass = 'bg-warning text-dark';
                } elseif ($rankInt === 2) {
                    $rankBadgeClass = 'bg-secondary text-white';
                } elseif ($rankInt === 3) {
                    $rankBadgeClass = 'bg-orange text-white';
                }
                ?>

                <div class="bg-light text-dark d-flex align-items-center px-2 py-2 py-lg-3 rounded-3 mb-3 mx-0">
                    <div class="col-3 col-sm-2">
                        <span class="badge <?php echo $rankBadgeClass; ?> py-2 py-lg-3 px-3 fw-bold">
                            <?php echo $yourRank; ?>
                        </span>
                    </div>
                    <div class="col ps-2 fw-semibold text-truncate">You</div>
                    <div class="col-3 col-sm-2 text-end pe-1 fw-bold">
                        <?php echo $yourPoints; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // JUMP TO LEADERBOARD SECTION
            if (window.location.hash === "#leaderboard") {
                const html = document.documentElement;
                const originalScrollBehavior = html.style.scrollBehavior;
                html.style.scrollBehavior = "auto";

                const target = document.querySelector('#leaderboard');
                if (target) {
                    target.scrollIntoView();
                }

                html.style.scrollBehavior = originalScrollBehavior;
            }
        });
    </script>
</div>

<!-- Dialogflow Chatbot -->
<?php include("views/chatbot.html"); ?>