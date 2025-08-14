<!-- ACHIEVEMENTS -->
<?php
$showNewBadge = false;

if (isset($_SESSION['newlyEarnedBadges'])) {
    $newlyEarnedBadges = $_SESSION['newlyEarnedBadges'];
    $showNewBadge = true;
    unset($_SESSION['newlyEarnedBadges']);
}
?>


<div class="container">

    <div class="container px-0 py-4 mb-3 mt-2">
        <div class="row">
            <div class="col-12">
                <div class="heading">BADGES</div>
                <hr class="border-3 border-dark opacity-100 m-0">

                <div class="overflow-auto px-2 mt-5">
                    <div class="d-flex flex-nowrap justify-content-center gap-5 py-3 min-scroll-width">

                        <?php while ($badge = mysqli_fetch_assoc($badgesResult)): ?>
                            <?php
                            $isUnlocked = in_array($badge['badgeID'], $earnedBadgeIDs);
                            $badgeIcon = "../assets/img/badges/" . $badge['iconUrl'];
                            $badgeName = htmlspecialchars($badge['badgeName']);
                            $badgeDesc = htmlspecialchars($badge['description']);
                            ?>

                            <div
                                class="card text-center px-3 py-3 text-white rounded-4 bg-container badge-card <?= $isUnlocked ? '' : 'locked' ?>">
                                <img src="<?= $badgeIcon ?>" class="img-fluid mx-auto mb-2 badge-image"
                                    alt="<?= $badgeName ?>">
                                <div class="fw-bold <?= $isUnlocked ? '' : 'text-muted' ?>"><?= $badgeDesc ?></div>
                                <?php if (!$isUnlocked): ?>
                                    <i class="bi bi-lock-fill position-absolute top-0 end-0 m-2 text-white opacity-75"></i>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- COMMUNITY LEADERBOARD -->
    <div id="leaderboard" class="heading mt-5">COMMUNITY LEADERBOARD</div>
    <hr style="border-top: 3px solid #000; opacity: 1; margin:0;">
    <div class="container my-5 px-0 rounded-4 overflow-y-scroll" style="max-height: 700px; scrollbar-color: #f8f9fa #f8f9fa; scrollbar-width: thin;">
        <div class="bg-container text-white p-3 p-md-5 rounded-5">

            <!-- Filter Buttons -->
            <div class="row row-cols-1 row-cols-md-3 g-2 g-md-5 mb-4 mb-md-5 mx-0">
                <!-- All Time -->
                <div class="col px-1">
                    <a href="<?= $baseURL ?>&filter=all#leaderboard"
                        class="btn rounded-pill px-2 px-md-4 fw-bold w-100 <?= $filter === 'all' ? 'bg-white text-dark' : 'text-white' ?>"
                        style="border: 2px solid white;">
                        ALL TIME
                    </a>
                </div>

                <!-- Monthly -->
                <div class="col px-1">
                    <a href="<?= $baseURL ?>&filter=monthly#leaderboard"
                        class="btn rounded-pill px-2 px-md-4 fw-bold w-100 <?= $filter === 'monthly' ? 'bg-white text-dark' : 'text-white' ?>"
                        style="border: 2px solid white;">
                        MONTHLY
                    </a>
                </div>

                <!-- Weekly -->
                <div class="col px-1">
                    <a href="<?= $baseURL ?>&filter=weekly#leaderboard"
                        class="btn rounded-pill px-2 px-md-4 fw-bold w-100 <?= $filter === 'weekly' ? 'bg-white text-dark' : 'text-white' ?>"
                        style="border: 2px solid white;">
                        WEEKLY
                    </a>
                </div>
            </div>

            <!-- Leaderboard Header -->
            <div class="d-flex fs-6 bg-secondary text-white px-2 py-2 py-lg-3 rounded-3 mb-2 mx-0">
                <div class="col-3 col-sm-2 fw-bold ps-1">RANK</div>
                <div class="col fw-bold ps-2">NAME</div>
                <div class="col-3 col-sm-2 fw-bold text-end pe-1">POINTS</div>
            </div>

            <!-- Leaderboard Entries -->
            <?php
            // Function to determine badge class based on rank
            function getBadgeClassFromRank($rankPosition)
            {
                $rankPosition = (int) $rankPosition;
                $defaultClass = 'border border-dark text-dark';

                if ($rankPosition === 1) {
                    return 'bg-warning text-dark';
                } elseif ($rankPosition === 2) {
                    return 'bg-secondary text-white';
                } elseif ($rankPosition === 3) {
                    return 'bg-orange text-white';
                }
                return $defaultClass;
            }
            ?>

            <?php if (empty($leaderboard)): ?>
                <div class="bg-light text-dark text-center px-3 py-4 rounded-3 mb-3">
                    <strong>
                        <?php
                        if ($filter === 'weekly') {
                            echo "No one has taken the lead yet this week!";
                        } elseif ($filter === 'monthly') {
                            echo "No one has taken the lead yet this month!";
                        } else {
                            echo "No one has ever taken the lead yet!";
                        }
                        ?>
                    </strong><br>
                    <span class="text-muted small">
                        Check in to your workouts and claim your place on the board!
                    </span>
                </div>
            <?php else: ?>
                <?php foreach ($leaderboard as $leaderboardEntry): ?>
                    <?php
                    $badgeStyleClass = getBadgeClassFromRank($leaderboardEntry['rank']);
                    ?>
                    <div class="bg-light text-dark d-flex align-items-center px-2 py-2 py-lg-3 rounded-3 mb-2 mx-0">
                        <div class="col-3 col-sm-2">
                            <span class="badge <?= $badgeStyleClass ?> py-2 py-lg-3 px-3 fw-bold">
                                <?= (int) $leaderboardEntry['rank'] ?>
                            </span>
                        </div>
                        <div class="col ps-2 fw-semibold text-truncate">
                            <?= htmlspecialchars($leaderboardEntry['username']) ?>
                        </div>
                        <div class="col-3 col-sm-2 fw-bold text-end pe-1">
                            <?= (int) $leaderboardEntry['points'] ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <!-- Current User's Rank -->
            <?php if ($yourRank !== null && !empty($leaderboard)): ?>
                <div class="text-center text-white fw-bold text-uppercase mt-4 mt-md-5 mb-3 mb-md-4">
                    Your Current Ranking
                </div>

                <?php
                $userBadgeClass = getBadgeClassFromRank($yourRank);
                ?>

                <div class="bg-light text-dark d-flex align-items-center px-2 py-2 py-lg-3 rounded-3 mb-3 mx-0">
                    <div class="col-3 col-sm-2">
                        <span class="badge <?= $userBadgeClass ?> py-2 py-lg-3 px-3 fw-bold">
                            <?= (int) $yourRank ?>
                        </span>
                    </div>
                    <div class="col ps-2 fw-semibold text-truncate">You</div>
                    <div class="col-3 col-sm-2 text-end pe-1 fw-bold">
                        <?= (int) $yourPoints ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Auto-scroll to leaderboard -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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