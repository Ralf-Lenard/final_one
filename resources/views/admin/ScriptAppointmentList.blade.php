<!-- jQuery (required for FullCalendar AJAX operations) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var selectedDate = null;

        // Add CSRF token to AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Initialize FullCalendar
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            dateClick: function(info) {
                if (selectedDate) {
                    document.querySelector(`.fc-day[data-date="${selectedDate}"]`).classList.remove('highlighted-date');
                }

                selectedDate = info.dateStr;
                info.dayEl.classList.add('highlighted-date');
                fetchAppointmentsForDate(info.dateStr);
            }
        });

        calendar.render();

        $(document).ready(function() {
            $('#show-all-appointments').on('click', function() {
                $('#selected-date').text('All Dates');
                $.ajax({
                    url: '{{ route("admin.appointments.all") }}',
                    method: 'GET',
                    success: function(response) {
                        // Populate both adoption and abuse appointments tables
                        populateAdoptionAppointmentsTable(response.adoptionAppointments, '#adoption-appointments-table');
                        populateAbuseAppointmentsTable(response.abuseAppointments, '#abuse-appointments-table');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error fetching all appointments:', textStatus, errorThrown);
                        alert('Failed to fetch all appointments. Please try again.');
                    }
                });
            });
        });


        function fetchAppointmentsForDate(date) {
            $.ajax({
                url: '{{ route("admin.appointments.byDate") }}',
                method: 'GET',
                data: {
                    date: date
                },
                success: function(response) {
                    $('#selected-date').text(date);
                    // Populate both adoption and abuse appointments tables
                    populateAdoptionAppointmentsTable(response.adoptionAppointments, '#adoption-appointments-table'),
                        populateAbuseAppointmentsTable(response.abuseAppointments, '#abuse-appointments-table')
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error fetching appointments:', textStatus, errorThrown);
                    alert('Failed to fetch appointments. Please try again.');
                }
            });
        }


        function populateAdoptionAppointmentsTable(appointments, tableId) {
            var tbody = $(tableId + ' tbody');
            tbody.empty();

            if (appointments.length === 0) {
                tbody.append('<tr><td colspan="6">No meetings found.</td></tr>');
            } else {
                $.each(appointments, function(index, appointment) {
                    tbody.append(`
                <tr>
                    <td>${appointment.meeting_date}</td>
                    <td>${appointment.adoption_request ? (appointment.adoption_request.user ? appointment.adoption_request.user.name : 'N/A') : 'N/A'}</td>
                    <td>${appointment.adoption_request ? (appointment.adoption_request.animal_profile ? appointment.adoption_request.animal_profile.name : 'N/A') : 'N/A'}</td>
                    <td>
                        <button class="btn btn-warning update-schedule-btn" data-id="${appointment.id}" data-date="${appointment.meeting_date}">Update</button>
                    </td>
                    <td>
                        <form method="post" action="{{ route('createMeetingAdoption') }}">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary"><i class="fas fa-video"></i></button>
                        </form>
                    </td>
                    <td>
                        <form action="/adoption/requests/${appointment.id}/complete" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                Complete Verification
                            </button>
                        </form>
                    </td>
                </tr>
            `);
                });
            }
        }

        function populateAbuseAppointmentsTable(appointments, tableId) {
    var tbody = $(tableId + ' tbody');
    tbody.empty();

    if (appointments.length === 0) {
        tbody.append('<tr><td colspan="6">No meetings found.</td></tr>');
    } else {
        $.each(appointments, function(index, appointment) {
            console.log(appointment); // Check the structure

            // Access user name from the nested object
            const userName = appointment.animal_abuse_report.user ? 
                             appointment.animal_abuse_report.user.name : 'N/A';

            tbody.append(`
                <tr>
                    <td>${moment(appointment.meeting_date).format('DD-MM-YYYY HH:mm')}</td>
                    <td>${userName}</td>
                    <td>
                        <button class="btn btn-warning update-schedule-btn" data-id="${appointment.id}" data-date="${appointment.meeting_date}">Update</button>
                    </td>
                    <td>
                        <form method="post" action="{{ route('createMeetingAbuse') }}">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary"><i class="fas fa-video"></i></button>
                        </form>
                    </td>
                    <td>
                        <form action="/abuses/requests/${appointment.id}/complete" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                Complete Verification
                            </button>
                        </form>
                    </td>
                </tr>
            `);
        });
    }
}


        var modal = document.getElementById('updateScheduleModal');
        var span = document.getElementsByClassName('close')[0];

        $(document).on('click', '.update-schedule-btn', function() {
            var id = $(this).data('id');
            var date = $(this).data('date');
            $('#meeting_id').val(id);
            $('#new_meeting_date').val(new Date(date).toISOString().slice(0, 16));
            modal.style.display = 'block';
        });

        span.onclick = function() {
            modal.style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }

        $('#updateScheduleForm').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: '{{ route("admin.meeting.update") }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    modal.style.display = 'none';
                    fetchAppointmentsForDate($('#selected-date').text());
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error updating schedule:', textStatus, errorThrown);
                    alert('Failed to update schedule. Please try again.');
                }
            });
        });
    });
</script>