// Chart
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('loginChart').getContext('2d');

    // Get last 7 days
    const labels = Array.from({length: 7}, (_, i) => {
        const d = new Date();
        d.setDate(d.getDate() - i);
        return d.toLocaleDateString();
    }).reverse();

    const data = {
        labels: labels,
        datasets: [{
            label: 'Login Count',
            data: loginData, // Get data from blade template variable
            fill: true,
            borderColor: '#f7adff',
            backgroundColor: 'rgba(232,171,255,0.1)',
            tension: 0.4
        }]
    };

    new Chart(ctx, {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 5,
                        color: '#2a54ff',
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        color: 'rgba(113,81,255,0.1)',
                        drawBorder: false
                    }
                },
                x: {
                    ticks: {
                        color: '#2a54ff',
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        display: false,
                        color: 'rgba(113,81,255,0.1)',
                        drawBorder: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
