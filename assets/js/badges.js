document.addEventListener("DOMContentLoaded", () => {

    // Show badge modal if applicable
    const showBadge = window.showBadge;
    const newlyEarnedBadges = window.newlyEarnedBadges;
    const currentPage = window.currentPage;

    if (currentPage === "achievements" && showBadge && newlyEarnedBadges.length > 0) {
        const badge = newlyEarnedBadges[0];
        document.getElementById('badgeIcon').src = `../assets/img/badges/${badge.icon}`;
        document.getElementById('badgeName').textContent = badge.name;
        document.getElementById('badgeDesc').textContent = badge.desc;

        const modal = new bootstrap.Modal(document.getElementById('badgeEarnedModal'));
        modal.show();

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
