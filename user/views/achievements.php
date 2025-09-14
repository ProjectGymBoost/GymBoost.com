<!-- ACHIEVEMENTS -->
<?php
// Check if the user has seen the modal.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dismiss_badge_modal'])) {
    $userID = $_SESSION['userID'];
    $updateQuery = "UPDATE user_badges SET dismissed = 1 WHERE userID = $userID AND dismissed = 0";
    mysqli_query($conn, $updateQuery);

    header("Location: ?page=achievements");
    exit();
}
checkAndAssignBadges($conn, $userID);

$showNewBadge = false;
$newlyEarnedBadges = [];

// Query the database directly for any newly earned, un-dismissed badges.
$query = "SELECT b.badgeName, b.description, b.iconUrl
          FROM user_badges ub
          JOIN badges b ON ub.badgeID = b.badgeID
          WHERE ub.userID = $userID AND ub.dismissed = 0";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $badgeData = array();
    $badgeData['badgeName'] = $row['badgeName'];
    $badgeData['description'] = $row['description'];
    $badgeData['iconUrl'] = $row['iconUrl'];
    $newlyEarnedBadges[] = $badgeData;
}

if (!empty($newlyEarnedBadges)) {
    $showNewBadge = true;
}

// Fetch the badges and earned badge IDs from the database to display
$resultArr = fetchBadgesAndEarned($conn, $userID);
$badgesResult = $resultArr[0];
$earnedBadgeIDs = $resultArr[1];
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
</div>

<!-- Badge Earned Modal -->
<div class="modal fade" id="badgeEarnedModal" tabindex="-1" aria-labelledby="badgeEarnedLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header text-white" style="background-color: var(--primaryColor)">
                <h5 class="modal-title" id="badgeEarnedLabel">🎉 New Badge Earned!</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="badgeIcon" src="" alt="Badge Icon" class="img-fluid mb-3" style="max-width: 100px;" />
                <h5 id="badgeName" class="fw-bold"></h5>
                <p id="badgeDesc"></p>
            </div>
        </div>
    </div>
</div>

<!-- JS for modal -->
<script>
    const showBadge = <?php echo json_encode($showNewBadge); ?>;
    const newlyEarnedBadges = <?php echo json_encode($newlyEarnedBadges); ?>;
    const currentPage = "achievements";

    document.addEventListener("DOMContentLoaded", () => {
        if (currentPage === "achievements" && showBadge && newlyEarnedBadges.length > 0) {
            const badge = newlyEarnedBadges[0];
            document.getElementById('badgeIcon').src = `../assets/img/badges/${badge.iconUrl}`;
            document.getElementById('badgeName').textContent = badge.badgeName;
            document.getElementById('badgeDesc').textContent = badge.description;

            const modal = new bootstrap.Modal(document.getElementById('badgeEarnedModal'));
            modal.show();

            // For audio
            const audio = new Audio('../assets/img/badges/badge_audio.mp3');
            audio.play();

            setTimeout(() => {
                confetti({
                    particleCount: 150,
                    spread: 80,
                    origin: { y: 0.6 }
                });
            }, 300);
        }

        // Dismiss modal logic
        const badgeModal = document.getElementById('badgeEarnedModal');
        if (badgeModal) {
            badgeModal.addEventListener('hide.bs.modal', () => {
                const form = document.createElement("form");
                form.method = "POST";
                form.style.display = "none";
                const input = document.createElement("input");
                input.name = "dismiss_badge_modal";
                input.value = "1";
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            });
        }
    });
</script>

<!-- COMMUNITY LEADERBOARD -->
<div class="container">
    <div id="leaderboard" class="heading mt-5">COMMUNITY LEADERBOARD</div>
    <hr style="border-top: 3px solid #000; opacity: 1; margin:0;">
    <div class="container my-5 px-0 rounded-4 overflow-y-scroll"
        style="max-height: 700px; scrollbar-color: #f8f9fa #f8f9fa; scrollbar-width: thin;">
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
                if (!is_numeric($rankPosition)) {
                    return 'border border-dark text-dark';
                }

                $rankPosition = (int) $rankPosition;
                if ($rankPosition === 1) {
                    return 'bg-warning text-dark';
                } elseif ($rankPosition === 2) {
                    return 'bg-secondary text-white';
                } elseif ($rankPosition === 3) {
                    return 'bg-orange text-white';
                }
                return 'border border-dark text-dark';
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
                                <?= is_numeric($leaderboardEntry['rank']) ? (int) $leaderboardEntry['rank'] : '—' ?>
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
                            <?= is_numeric($yourRank) ? (int) $yourRank : '—' ?>
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