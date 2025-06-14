// Chart.js for index.php part of the Admin Dashboard Graph for Attendance Report and Member Distribution

// Bar Chart Data
var barLabels = ["Jan", "Feb", "March", "April", "May", "June", "July", "August"];
var barData = [2, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
var barColors = ["#1f2a3c", "#334566 ", "#60779c"];

new Chart("barChart", {
    type: "bar",
    data: {
        labels: barLabels,
        datasets: [{
            backgroundColor: barColors,
            data: barData
        }]
    },
    options: {
        plugins: {
            legend: { display: false },
            title: { display: false }
        },
        scales: {
            x: { grid: { display: false } },
            y: { grid: { display: false }, suggestedMin: 0, suggestedMax: 7 }
        }
    }
});

// Pie Chart Data
var pieLabels = ["Half Month", "Monthly", "2 Months", "6 Months"];
var pieData = [55, 49, 44, 43];
var pieColors = ["#334566", "#60779c", "#1f2a3c", "#b0b0b0"];

new Chart("pieChart", {
    type: "pie",
    data: {
        labels: pieLabels,
        datasets: [{
            backgroundColor: pieColors,
            data: pieData
        }]
    },
    options: {
        maintainAspectRatio: false,
        plugins: {
            title: { display: false },
            legend: {
                position: 'left',
                labels: {
                    usePointStyle: true,
                    pointStyle: 'circle',
                    font: { size: 14 },
                    pointStyleWidth: 18,
                    padding: 20
                }
            }
        }
    }
});