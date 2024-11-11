<script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.11.1/toastify.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.11.1/toastify.min.css">

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>



<script>
    // Enable Pusher logging - don't include this in production
    Pusher.logToConsole = true;

    // Initialize Pusher
    var pusher = new Pusher('c27cf1cca7e151dffc12', {
        cluster: 'ap1'
    });

    // Subscribe to the adoption requests channel
    var adoptionChannel = pusher.subscribe('adoption-requests');
    adoptionChannel.bind('adoption-request.submitted', function(data) {
        console.log('Adoption Request Received:', data); // Log data for debugging

        var adoptionRequest = data.adoptionRequest;

        if (adoptionRequest) {
            // Use Toastify to display the notification
            Toastify({
                text: `New Adoption Request Submitted by ${adoptionRequest.first_name || 'Unknown'} ${adoptionRequest.last_name || 'Unknown'}`,
                duration: 5000,
                close: true,
                gravity: "top",
                position: "right",
                style: {
                    background: "#4fbe87"
                },
                stopOnFocus: true
            }).showToast();


            // Append the notification to the notification list
            var notificationList = document.getElementById('notification-list');
            if (notificationList) {
                var newNotification = document.createElement('li');
                newNotification.innerHTML = `
                    New Adoption Request from <strong>${adoptionRequest.first_name || 'Unknown'} ${adoptionRequest.last_name || 'Unknown'}</strong>
                `;

                // Check if there are already three notifications
                if (notificationList.children.length >= 3) {
                    // Remove the last notification
                    notificationList.removeChild(notificationList.lastElementChild);
                }

                // Append the new notification
                notificationList.appendChild(newNotification);
            }
        }
    });

    // Subscribe to the abuse reports channel
    var abuseReportsChannel = pusher.subscribe('abuse-reports');

    abuseReportsChannel.bind('AnimalAbuseReportSubmitted', function(data) {
        console.log('Received data:', data); // Log the entire data object for debugging

        var abuseReport = data.report; // Access the abuse report data

        if (abuseReport) {
            // Show toast notification
            Toastify({
                text: `New Animal Abuse Report Submitted by ${abuseReport.reporter_name}`,
                duration: 5000,
                close: true,
                gravity: "top",
                position: "right",
                style: {
                    background: "#d9534f"
                },
                stopOnFocus: true
            }).showToast();

            // Append the notification
            var notificationList = document.getElementById('notification-list');
            var newNotification = document.createElement('li');
            newNotification.innerHTML = `
            <div class="d-flex justify-content-between align-items-start">
                <div class="notification-message">
                    New Animal Abuse Report by <strong>${abuseReport.reporter_name}</strong>
                </div>
                <div class="notification-time">
                    <small class="text-muted">Just now</small>
                </div>
            </div>
        `;
            notificationList.appendChild(newNotification);

            // Manage the maximum number of notifications (3)
            var notifications = notificationList.getElementsByTagName('li');
            if (notifications.length > 3) {
                // Remove the oldest notification
                notificationList.removeChild(notifications[0]); // Removes the first notification
            }

            // Add a divider for new notifications
            if (notifications.length > 1) {
                var divider = document.createElement('div');
                divider.className = 'dropdown-divider';
                notificationList.appendChild(divider);
            }
        } else {
            console.error('Reported user is undefined or has no name.');
        }
    });
</script>






<script>
    document.addEventListener('DOMContentLoaded', () => {
        const ctx = document.getElementById('intakeVsAdoptionsChart');

        if (!ctx) {
            console.error("Canvas element 'intakeVsAdoptionsChart' not found.");
            return;
        }

        const intakeGradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
        intakeGradient.addColorStop(0, 'rgba(255, 99, 132, 0.8)');
        intakeGradient.addColorStop(1, 'rgba(255, 99, 132, 0.2)');

        const adoptionGradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
        adoptionGradient.addColorStop(0, 'rgba(54, 162, 235, 0.8)');
        adoptionGradient.addColorStop(1, 'rgba(54, 162, 235, 0.2)');

        const intakeVsAdoptionChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($months),
                datasets: [{
                        label: 'Animal Intake',
                        data: @json($intakeData),
                        backgroundColor: intakeGradient,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        borderRadius: 5,
                        borderSkipped: false,
                    },
                    {
                        label: 'Adoptions',
                        data: @json($adoptionData),
                        backgroundColor: adoptionGradient,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        borderRadius: 5,
                        borderSkipped: false,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 12,
                                weight: 'bold'
                            },
                            usePointStyle: true,
                            padding: 20
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
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += context.parsed.y;
                                }
                                return label;
                            }
                        }
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
                                return value.toLocaleString();
                            }
                        }
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeOutQuart'
                },
                onResize: function(chart, size) {
                    if (size.width < 400) {
                        chart.options.scales.x.ticks.font.size = 10;
                        chart.options.scales.y.ticks.font.size = 10;
                    } else {
                        chart.options.scales.x.ticks.font.size = 12;
                        chart.options.scales.y.ticks.font.size = 12;
                    }
                }
            }
        });

        // Redraw chart on window resize
        window.addEventListener('resize', () => {
            intakeVsAdoptionChart.resize();
        });
    });
</script>

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





<script>
    // Function to update or add an animal profile to the list
    function updateAnimalList(animal) {
        var animalElement = $(`#animal-${animal.id}`);
        if (animalElement.length) {
            // Update existing animal element
            animalElement.find('img').attr('src', `/storage/${animal.profile_picture}?t=${new Date().getTime()}`);
            animalElement.find('h4').text(animal.name);
            animalElement.find('h4').text(animal.species);
            animalElement.find('h6').text(animal.age);
            animalElement.find('.description').text(animal.description);
        } else {
            // Append new animal element if not found
            $('#animal-list').append(`
                <div class="col-md-4" id="animal-${animal.id}">
                    <div class="product-item">
                        <a href="#">
                            <img src="/storage/${animal.profile_picture}" class="card-img-top" alt="${animal.name}">
                        </a>
                        <div class="down-content">
                            <a href="#">
                                <h4>${animal.name}</h4>
                            </a>
                            <h6>${animal.age}</h6>
                            <p class="description" data-description="${animal.description}"></p>
                            <span><a href="/animals/${animal.id}">View Profile</a></span>
                        </div>
                    </div>
                </div>
            `);
        }
    }
</script>

<script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('c27cf1cca7e151dffc12', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
        $.ajax({
            url: "{{route('unreadcount')}}",
            method: "GET",
            success: function(data) {
                $('.unread_message').html(data.count);
            }
        })
    });
</script>