// Loading of Top 10 Active Members
function loadTopMembers() {
    const tbody = document.getElementById("top10Tbody");
    if (!tbody) return;

    fetch("../assets/php/processes/admin/index.php")
        .then(response => response.json())
        .then(data => {
            tbody.innerHTML = "";

            if (data.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="4" style="color:#D2042D; font-weight: bold; text-align: center;">No Data Available</td>
                    </tr>
                `;
                return;
            }

            data.forEach((member, index) => {
                let awardIcon = "";
                if (index === 0) awardIcon = '<i class="bi bi-award-fill text-warning me-2"></i>';
                else if (index === 1) awardIcon = '<i class="bi bi-award-fill text-primary me-2"></i>';
                else if (index === 2) awardIcon = '<i class="bi bi-award-fill text-secondary me-2"></i>';

                // Apply <strong> only for top 3
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
        })
        .catch(err => {
            console.error("Failed to fetch active members:", err);
            tbody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center text-danger fw-bold">Error loading data</td>
                </tr>
            `;
        });
}

// Automatic refresh every 30 secs 
document.addEventListener("DOMContentLoaded", function () {
    loadTopMembers(); 
    setInterval(loadTopMembers, 30000); 
});

