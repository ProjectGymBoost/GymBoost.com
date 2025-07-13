// Chart.js for workout.php part of the Workout Statistics Graph for WORKOUT TYPE TRACKER and MONTHLY WORKOUT FREQUENCY

// Pie Chart Data
var pieLabels = ["Cardio", "Strength", "Flexibility"];
var pieData = [55, 49, 44];
var pieColors = ["#60779c", "#334566", "#1f2a3c"];

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
                position: 'right',
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

// Bar Chart Data
var barLabels = ["January", "February", "March", "April", "May", "June", "July"];
var barData = [12, 18, 10, 22, 25, 30, 2];
var barColors = ["#b0b0b0", "#1f2a3c", "#60779c", "#334566", "#1f2a3c","#b0b0b0", "#1f2a3c"];

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
        maintainAspectRatio: false,
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