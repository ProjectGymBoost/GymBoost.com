// Chart.js for index.php part of the Admin Dashboard Graph for Attendance Report and Member Distribution

// Bar Chart Data
var barLabels = ["Jan", "Feb", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
var barData = [20, 40, 60, 50, 65, 45, 62, 35, 100, 20, 40, 30];
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
var pieLabels = ["Half Month", "1 Month", "2 Months", "3 Months", "Semi-annual", "Annual"];
var pieData = [20, 12, 18, 10, 15, 12];
var pieColors = ["#b0b0b0", "#60779c", "#334566", "#1f2a3c", "#49546a", "#8a99b5"];

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

var ageLabels = ["Senior (60+)", "Middle-Aged Adult (40-59)", "Young Adults (20-39)", "Teenagers (13-19)"];
var ageData = [0, 15, 50, 22];
var ageColors = ["#b0b0b0", "#60779c", "#334566", "#1f2a3c"];

var labelFontSize = window.innerWidth <= 767.98 ? 10 : 14;

new Chart("doughnutChart", {
    type: "doughnut",
    data: {
        labels: ageLabels,
        datasets: [{
            backgroundColor: ageColors,
            data: ageData
        }]
    },
    options: {
        maintainAspectRatio: false,
        cutout: '60%',
        plugins: {
            title: { display: false },
            legend: {
                position: 'left',
                labels: {
                    usePointStyle: true,
                    pointStyle: 'circle',
                    font: { size: labelFontSize }, 
                    pointStyleWidth: 18,
                    padding: 20
                }
            }
        }
    }
});
