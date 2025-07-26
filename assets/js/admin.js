// Loading of Dashboard Stats and Top 10 Active Members
function loadTopMembersAndStats() {
    const tbody = document.getElementById("top10Tbody");
    if (!tbody) return;

    fetch("../assets/php/processes/admin/index.php")
        .then(response => response.json())
        .then(data => {
            // Top 10 Active Members
            const members = data.topMembers || [];
            tbody.innerHTML = "";

            if (members.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="4" style="color:#D2042D; font-weight: bold; text-align: center;">No Data Available</td>
                    </tr>
                `;
            } else {
                members.forEach((member, index) => {
                    let awardIcon = "";
                    if (index === 0) awardIcon = '<i class="bi bi-award-fill text-warning me-2"></i>';
                    else if (index === 1) awardIcon = '<i class="bi bi-award-fill text-primary me-2"></i>';
                    else if (index === 2) awardIcon = '<i class="bi bi-award-fill text-secondary me-2"></i>';

                    const name = index <= 2 ? `<strong>${member.fullName}</strong>` : member.fullName;
                    const workouts = index <= 2 ? `<strong>${member.workoutsThisMonth}</strong>` : member.workoutsThisMonth;
                    const points = index <= 2 ? `<strong>${member.points}</strong>` : member.points;

                    tbody.innerHTML += `
                        <tr>
                            <td class="d-flex align-items-center fw-bold">${awardIcon} ${index + 1}</td>
                            <td>${name}</td>
                            <td>${workouts}</td>
                            <td>${points}</td>
                        </tr>
                    `;
                });
            }

            // Dashboard Stats
            const stats = data.stats || {};

            document.getElementById('usersCount').textContent = parseInt(stats.totalUsers) || 0;
            document.getElementById('activeMembersCount').textContent = parseInt(stats.activeMembers) || 0;
            document.getElementById('inactiveMembersCount').textContent = parseInt(stats.inactiveMembers) || 0;
            document.getElementById('newMembersCount').textContent = parseInt(stats.newMembers) || 0;
            document.getElementById('attendanceTodayCount').textContent = parseInt(stats.attendanceToday) || 0;
            document.getElementById('totalPlansCount').textContent = parseInt(stats.totalPlans) || 0;
        })
        .catch(err => {
            console.error("Failed to load dashboard data:", err);
        });
}

// Automatic refresh every 30 secs 
document.addEventListener("DOMContentLoaded", function () {
    loadTopMembersAndStats();
    setInterval(loadTopMembersAndStats, 30000);
});
