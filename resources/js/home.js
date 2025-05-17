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


document.addEventListener('DOMContentLoaded', function() {
    // If requestsChart exists on the page and requestStats is defined
    const requestsChartEl = document.getElementById('requestsChart');
    if (requestsChartEl && typeof requestStats !== 'undefined') {
        new Chart(requestsChartEl, {
            type: 'doughnut',
            data: {
                labels: ['Approved', 'Rejected', 'Pending'],
                datasets: [{
                    data: [
                        requestStats.approved,
                        requestStats.rejected,
                        requestStats.pending
                    ],
                    backgroundColor: [
                        'rgb(42,84,255)',
                        'rgb(255,204,242)',
                        'rgb(153,125,255)'
                    ],
                    borderWidth: 0,

                }]
            },
            options: {
                cutout: '60%',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        gap: 10,
                        align: 'center',
                        labels: {
                            boxWidth: 16,
                            padding: 15,
                            font: {
                                size: 16
                            }
                        }

                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.formattedValue;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.raw / total) * 100).toFixed(1);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    }
});

// Weekly requests trend chart
document.addEventListener('DOMContentLoaded', function() {
    const weeklyRequestsChartEl = document.getElementById('weeklyRequestsChart');
    if (weeklyRequestsChartEl && typeof weeklyRequestsData !== 'undefined') {
        // Extract labels (weeks) and data from the weeklyRequestsData
        const labels = weeklyRequestsData.map(item => item.week);
        const approvedData = weeklyRequestsData.map(item => item.approved);
        const rejectedData = weeklyRequestsData.map(item => item.rejected);

        new Chart(weeklyRequestsChartEl, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Approved',
                        data: approvedData,
                        backgroundColor: 'rgb(42,84,255)',
                        borderColor: 'rgb(42,84,255)',
                        borderWidth: 1
                    },
                    {
                        label: 'Rejected',
                        data: rejectedData,
                        backgroundColor: 'rgb(255,204,242)',
                        borderColor: 'rgb(255,204,242)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#2a54ff'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            color: '#2a54ff'
                        },
                        grid: {
                            color: 'rgba(113, 81, 255, 0.1)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            boxWidth: 12,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.parsed.y;
                                return label;
                            }
                        }
                    }
                },
                barThickness: 25, // Set fixed bar width
                maxBarThickness: 35 // Maximum bar width
            }
        });
    }
});
