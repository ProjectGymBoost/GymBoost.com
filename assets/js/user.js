// Chart.js for workout.php part of the Workout Statistics Graph for WORKOUT TYPE TRACKER and MONTHLY WORKOUT FREQUENCY

document.addEventListener("DOMContentLoaded", function () {
  if (typeof chartData === "undefined") return;

  const workoutColors = {
    "Cardio": "#60779c",
    "Strength": "#334566",
    "Flexibility": "#1f2a3c",
    "Chest": "#1f2a3c",
    "Back": "#334566",
    "Leg": "#60779c",
    "Shoulder": "#3a506b",
    "Arm": "#4b6584",
    "Abs": "#b0b0b0",
    "Full Body": "#1f2a3c"
  };

  // PIE CHART 
  const pieColors = chartData.typeLabels.map(label => workoutColors[label] || "#cccccc");
  const typeCtx = document.getElementById("workoutTypeChart")?.getContext("2d");
  if (typeCtx) {
    new Chart(typeCtx, {
      type: "pie",
      data: {
        labels: chartData.typeLabels,
        datasets: [{
          label: "",
          data: chartData.typeCounts,
          backgroundColor: pieColors
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
  }

  // BAR CHART
  const barColors = chartData.monthlyCounts.map((_, i) => {
    const defaultColors = [
      "#b0b0b0", "#1f2a3c", "#60779c", "#334566", "#1f2a3c",
      "#b0b0b0", "#1f2a3c", "#60779c", "#334566", "#1f2a3c",
      "#b0b0b0", "#1f2a3c"
    ];
    return defaultColors[i % defaultColors.length];
  });

  const monthlyCtx = document.getElementById("monthlyWorkoutChart")?.getContext("2d");
  if (monthlyCtx) {
    new Chart(monthlyCtx, {
      type: "bar",
      data: {
        labels: chartData.monthlyLabels,
        datasets: [{
          label: "Workout Sessions",
          data: chartData.monthlyCounts,
          backgroundColor: barColors
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
          y: {
            grid: { display: false },
            beginAtZero: true,
            ticks: {
              precision: 0
            }
          }
        }
      }
    });
  }
});
