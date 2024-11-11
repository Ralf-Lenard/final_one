<script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.11.1/toastify.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.11.1/toastify.min.css">

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<script>
    // Enable Pusher logging - don't include this in production
    Pusher.logToConsole = true;

    // Initialize Pusher
    var pusher = new Pusher('c27cf1cca7e151dffc12', {
        cluster: 'ap1'
    });

    // Subscribe to the channel we specified in our Laravel Event
    var channel = pusher.subscribe('abuse-reports');

    // Listen for the event
    channel.bind('AnimalAbuseReportSubmitted', function(data) {
        const report = data.report; // Extract the report data

        // Display a toast notification when new data is received
        Toastify({
            text: `New Abuse Report Submitted: ${report.description}`,
            duration: 5000,
            close: true,
            gravity: "top", // top or bottom
            position: "right", // left, center or right
            backgroundColor: "#4CAF50",
            stopOnFocus: true // Prevents dismissing of toast on hover
        }).showToast();

        let photosHtml = '';
        let photosAvailable = false;
        for (let i = 1; i <= 5; i++) {
            if (report['photos' + i]) {
                photosAvailable = true;
                const photoUrl = `/storage/${report['photos' + i]}`;
                photosHtml += `
                    <a href="#" data-toggle="modal" data-target="#imageModal" data-image="${photoUrl}">
                        <img width="100" height="100" src="${photoUrl}" class="img-thumbnail m-1" alt="Photo ${i}">
                    </a>`;
            }
        }
        if (!photosAvailable) {
            photosHtml = '<p class="text-muted">No photos available.</p>';
        }

        let videosHtml = '';
        let videosAvailable = false;
        for (let i = 1; i <= 3; i++) {
            if (report['videos' + i]) {
                videosAvailable = true;
                const videoUrl = `/storage/${report['videos' + i]}`;
                videosHtml += `
                    <a href="#" data-toggle="modal" data-target="#videoModal" data-video="${videoUrl}">
                        <video width="160" height="140" controls class="m-1">
                            <source src="${videoUrl}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </a>`;
            }
        }
        if (!videosAvailable) {
            videosHtml = '<p class="text-muted">No videos available.</p>';
        }

        let actionButtons = '';
        if (report.status === 'pending') {
            actionButtons = `
                <form action="/reports/${report.id}/verify" method="POST" class="d-inline">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-warning">Verify</button>
                </form>`;
        } else if (report.status === 'Verifying') {
            actionButtons = `
                <form action="/reports/${report.id}/approve" method="POST" class="d-inline">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-success">Approve</button>
                </form>
                <button type="button" class="btn btn-danger" onclick="showRejectModal(${report.id})">Reject</button>`;
        }

        // Append the new abuse report to the table
        $('#abuse-list').prepend(`
            <tr>
                <td>${report.description}</td>
                <td>
                    <div class="d-flex flex-wrap">
                        ${photosHtml}
                    </div>
                </td>
                <td>
                    <div class="d-flex flex-wrap">
                        ${videosHtml}
                    </div>
                </td>
                <td>${actionButtons}</td>
            </tr>
        `);
    });

    // Handle the modal for image preview
    $('#imageModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var imageUrl = button.data('image'); // Extract the image URL from the data-image attribute
        var modal = $(this);
        modal.find('#modalImage').attr('src', imageUrl); // Update the modal image source
    });

    // Handle the modal for video preview
    $('#videoModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var videoUrl = button.data('video'); // Extract the video URL from the data-video attribute
        var modal = $(this);
        modal.find('#modalVideo source').attr('src', videoUrl); // Update the modal video source
        modal.find('#modalVideo')[0].load(); // Reload the video to display it
    });
</script>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const abuseList = document.getElementById('abuse-list');
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');
        const pagination = document.getElementById('pagination');
        const itemsPerPage = 10; // Number of items per page
        let currentPage = 1;
        let filteredAbuses = [];

        // Initialize the table
        const abuses = Array.from(abuseList.children);
        filteredAbuses = abuses;
        updateTable();

        // Search functionality
        function performSearch() {
            const searchTerm = searchInput.value.toLowerCase();
            filteredAbuses = abuses.filter(abuse => {
                return abuse.textContent.toLowerCase().includes(searchTerm);
            });
            currentPage = 1;
            updateTable();
        }

        searchButton.addEventListener('click', performSearch);
        searchInput.addEventListener('keyup', function(event) {
            if (event.key === 'Enter') {
                performSearch();
            }
        });

        // Update table with current page items
        function updateTable() {
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const pageAbuses = filteredAbuses.slice(startIndex, endIndex);

            abuseList.innerHTML = '';
            pageAbuses.forEach(abuse => abuseList.appendChild(abuse));

            updatePagination();
        }

        // Update pagination controls based on filtered results
        function updatePagination() {
            const pageCount = Math.ceil(filteredAbuses.length / itemsPerPage);
            pagination.innerHTML = '';

            // Previous button
            const prevLi = document.createElement('li');
            prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
            prevLi.innerHTML = '<a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>';
            prevLi.addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    updateTable();
                }
            });
            pagination.appendChild(prevLi);

            // Page numbers
            for (let i = 1; i <= pageCount; i++) {
                const li = document.createElement('li');
                li.className = `page-item ${i === currentPage ? 'active' : ''}`;
                li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                li.addEventListener('click', () => {
                    currentPage = i;
                    updateTable();
                });
                pagination.appendChild(li);
            }

            // Next button
            const nextLi = document.createElement('li');
            nextLi.className = `page-item ${currentPage === pageCount ? 'disabled' : ''}`;
            nextLi.innerHTML = '<a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>';
            nextLi.addEventListener('click', () => {
                if (currentPage < pageCount) {
                    currentPage++;
                    updateTable();
                }
            });
            pagination.appendChild(nextLi);
        }

        // Initial table update
        updateTable();
    });

    // Show reject modal with form action set to appropriate URL
    function showRejectModal(abuseId) {
        const modal = document.getElementById('rejectAbusesModal');
        const form = document.getElementById('rejectForm');
        form.action = `/reject/${abuseId}`;
        new bootstrap.Modal(modal).show();
    }
</script>