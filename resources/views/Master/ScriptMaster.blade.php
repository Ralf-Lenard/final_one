<script>
    document.addEventListener('DOMContentLoaded', () => {
        const ctx = document.getElementById('adoptionRateChart');

        if (!ctx) {
            console.error("Canvas element 'adoptionRateChart' not found.");
            return;
        }

        // Use the rearranged data from the backend
        const months = @json($rearrangedMonths); // The months now start from the current month
        const adoptionRate = @json($rearrangedAdoptionRate); // Rearranged adoption rate data

        const gradientFill = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
        gradientFill.addColorStop(0, 'rgba(75, 192, 192, 0.6)');
        gradientFill.addColorStop(1, 'rgba(75, 192, 192, 0.1)');

        const adoptionRateChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: months, // Use the rearranged months from backend
                datasets: [{
                    label: 'Adoption Rate',
                    data: adoptionRate, // Use the rearranged adoption rate from backend
                    backgroundColor: gradientFill,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true, // Enable the legend to display the label
                        labels: {
                            font: {
                                size: 14 // Adjust the font size if needed
                            }
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        padding: 10,
                        cornerRadius: 4,
                        displayColors: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        },
                        ticks: {
                            font: {
                                size: 12
                            },
                            callback: function(value) {
                                return value + '%'; // Display percentage
                            }
                        }
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeOutQuart'
                },
                onResize: function(chart, size) {
                    const newSize = size.width < 400 ? 10 : 12;
                    chart.options.scales.x.ticks.font.size = newSize;
                    chart.options.scales.y.ticks.font.size = newSize;
                }
            }
        });

        // Redraw the chart on window resize
        window.addEventListener('resize', () => {
            adoptionRateChart.resize();
        });
    });
</script>
