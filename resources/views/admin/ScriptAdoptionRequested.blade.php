<script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.11.1/toastify.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.11.1/toastify.min.css">

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Enable Pusher logging - don't include this in production
    Pusher.logToConsole = true;

    // Initialize Pusher
    var pusher = new Pusher('c27cf1cca7e151dffc12', {
        cluster: 'ap1'
    });

    // Subscribe to the channel and bind to the event
    var channel = pusher.subscribe('adoption-requests');
    channel.bind('adoption-request.submitted', function(data) {
        console.log('Received data:', data); // Log data for debugging

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

            // Generate the action buttons based on the adoption request status
            let actionButtons = '';
            if (adoptionRequest.status === 'Pending') {
                actionButtons = `
                    <form action="/admin/adoption/${adoptionRequest.id}/verify" method="POST" class="d-inline">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-warning">Verify</button>
                    </form>
                `;
            } else if (adoptionRequest.status === 'Verifying') {
                actionButtons = `
                    <form action="/admin/adoption/${adoptionRequest.id}/approve" method="POST" class="d-inline">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-success">Approve</button>
                    </form>
                    <button type="button" class="btn btn-danger" onclick="showRejectModal(${adoptionRequest.id})">Reject</button>
                `;
            }

            // Append new adoption request to the table
            $('#dataTables-example tbody').prepend(`
                <tr class="odd gradeX">
                    <td>${adoptionRequest.first_name || 'N/A'}</td>
                    <td>${adoptionRequest.last_name || 'N/A'}</td>
                    <td>${adoptionRequest.gender || 'N/A'}</td>
                    <td>${adoptionRequest.phone_number || 'N/A'}</td>
                    <td>${adoptionRequest.address || 'N/A'}</td>
                    <td>${adoptionRequest.salary || 'N/A'}</td>
                    <td>${adoptionRequest.question1 || 'N/A'}</td>
                    <td>${adoptionRequest.question2 || 'N/A'}</td>
                    <td>${adoptionRequest.question3 || 'N/A'}</td>
                    <td>
                        <img width="40px" height="40px" src="${adoptionRequest.valid_id ? '/storage/' + adoptionRequest.valid_id : '/images/placeholder.png'}" class="card-img-top" alt="Valid ID">
                    </td>
                    <td>
                        <img width="40px" height="40px" src="${adoptionRequest.valid_id_with_owner ? '/storage/' + adoptionRequest.valid_id_with_owner : '/images/placeholder.png'}" class="card-img-top" alt="ID with User">
                    </td>
                    <td>${actionButtons}</td> 
                </tr>
            `);
        } else {
            console.error('adoptionRequest is undefined or not in the expected structure', data);
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const adoptionList = document.getElementById('adoption-list');
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');
        const pagination = document.getElementById('pagination');
        const itemsPerPage = 10;
        let currentPage = 1;
        let filteredAdoptions = [];

        // Initialize the table
        const adoptions = Array.from(adoptionList.children);
        filteredAdoptions = adoptions;
        updateTable();

        // Search functionality
        function performSearch() {
            const searchTerm = searchInput.value.toLowerCase();
            filteredAdoptions = adoptions.filter(adoption => {
                return adoption.textContent.toLowerCase().includes(searchTerm);
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

        // Pagination functionality
        function updateTable() {
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const pageAdoptions = filteredAdoptions.slice(startIndex, endIndex);

            adoptionList.innerHTML = '';
            pageAdoptions.forEach(adoption => adoptionList.appendChild(adoption));

            updatePagination();
        }

        function updatePagination() {
            const pageCount = Math.ceil(filteredAdoptions.length / itemsPerPage);
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

    function showRejectModal(adoptionId) {
        const modal = document.getElementById('rejectAdoptionModal');
        const form = document.getElementById('rejectForm');
        form.action = `/admin/adoption/${adoptionId}/reject`;
        new bootstrap.Modal(modal).show();
    }
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var idModal = document.getElementById('idModal');
        idModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var imgSrc = button.getAttribute('data-bs-img-src');
            var imgTitle = button.getAttribute('data-bs-img-title');
            var modalTitle = idModal.querySelector('.modal-title');
            var modalImage = document.getElementById('modalImage');

            modalTitle.textContent = imgTitle;
            modalImage.src = imgSrc;
            modalImage.alt = imgTitle;
        });
    });
</script>