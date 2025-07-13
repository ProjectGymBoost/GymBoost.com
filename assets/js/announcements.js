function loadAnnouncements(page = 1, limit = 5) {
    fetch(`../assets/php/processes/admin/announcement.php?ajax=true&page=${page}&limit=${limit}`)
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById("announcementTableBody");
            tbody.innerHTML = "";

            if (data.status === "success") {
                data.data.forEach((a) => {
                    const row = document.createElement("tr");

                    row.innerHTML = `
                        <td>${a.announcementID}</td>
                        <td>${a.title}</td>
                        <td>${a.message}</td>
                        <td class="d-flex flex-row justify-content-center">
                            <li>
                                <a data-bs-toggle="modal" data-bs-target="#editAnnouncement${a.announcementID}Modal">
                                    <i class="bi bi-pencil-square px-2"></i>
                                </a>
                            </li>
                            <li>
                                <a style="color: red;" data-bs-toggle="modal"
                                    data-bs-target="#deleteAnnouncement${a.announcementID}Modal">
                                    <i class="bi bi-trash3 px-2"></i>
                                </a>
                            </li>
                        </td>
                    `;
                    tbody.appendChild(row);
                });

                renderPagination(data.total, data.page, data.limit);
                const start = data.total === 0 ? 0 : (data.page - 1) * data.limit + 1;
                const end = Math.min(data.page * data.limit, data.total);
                document.getElementById("paginationInfo").textContent =
                    `Showing ${start} to ${end} of ${data.total} entries`;
            } else if (data.status === "empty") {
                tbody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">No announcements found.</td></tr>`;
                renderPagination(0, page, limit);
            } else {
                tbody.innerHTML = `<tr><td colspan="4" class="text-center text-danger">${data.message}</td></tr>`;
            }
        })
        .catch((error) => {
            document.getElementById("announcementTableBody").innerHTML = `
                <tr><td colspan="4" class="text-center text-danger">Error loading announcements.</td></tr>
            `;
            console.error("Fetch error:", error);
        });
}

function renderPagination(total, page, limit) {
    const totalPages = Math.ceil(total / limit);
    const paginationContainer = document.querySelector(".pagination");
    paginationContainer.innerHTML = "";

    paginationContainer.innerHTML += `
        <li class="page-item ${page === 1 ? "disabled" : ""}">
            <a class="page-link" href="#" data-page="${page - 1}">&laquo;</a>
        </li>
    `;

    for (let i = 1; i <= totalPages; i++) {
        paginationContainer.innerHTML += `
            <li class="page-item ${page === i ? "active" : ""}">
                <a class="page-link" href="#" data-page="${i}">${i}</a>
            </li>
        `;
    }

    paginationContainer.innerHTML += `
        <li class="page-item ${page === totalPages ? "disabled" : ""}">
            <a class="page-link" href="#" data-page="${page + 1}">&raquo;</a>
        </li>
    `;

    document.querySelectorAll(".page-link").forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const newPage = parseInt(this.dataset.page);
            const newLimit = document.getElementById("entriesCount").value || 5;
            if (!isNaN(newPage)) {
                loadAnnouncements(newPage, newLimit);
            }
        });
    });
}

document.addEventListener("DOMContentLoaded", () => {
    const entrySelector = document.getElementById("entriesCount");
    loadAnnouncements(1, entrySelector?.value || 5);

    if (entrySelector) {
        entrySelector.addEventListener("change", () => {
            loadAnnouncements(1, entrySelector.value);
        });
    }
});

