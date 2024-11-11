<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.11.1/toastify.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.11.1/toastify.min.css">

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const itemsPerPage = 10;

        // Adoption table
        const adoptionList = document.getElementById('adoption-list');
        const searchAdoptionInput = document.getElementById('searchAdoptionInput');
        const searchAdoptionButton = document.getElementById('searchAdoptionButton');
        const adoptionPagination = document.getElementById('adoptionPagination');
        let adoptionCurrentPage = 1;
        let filteredAdoptions = [];

        const adoptions = Array.from(adoptionList.children);
        filteredAdoptions = adoptions;
        updateAdoptionTable();

        function performAdoptionSearch() {
            const searchTerm = searchAdoptionInput.value.toLowerCase();
            filteredAdoptions = adoptions.filter(adoption => {
                return adoption.textContent.toLowerCase().includes(searchTerm);
            });
            adoptionCurrentPage = 1;
            updateAdoptionTable();
        }

        searchAdoptionButton.addEventListener('click', performAdoptionSearch);
        searchAdoptionInput.addEventListener('keyup', function(event) {
            if (event.key === 'Enter') {
                performAdoptionSearch();
            }
        });

        function updateAdoptionTable() {
            const startIndex = (adoptionCurrentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const pageAdoptions = filteredAdoptions.slice(startIndex, endIndex);

            adoptionList.innerHTML = '';
            pageAdoptions.forEach(adoption => adoptionList.appendChild(adoption));

            updateAdoptionPagination();
        }

        function updateAdoptionPagination() {
            const pageCount = Math.ceil(filteredAdoptions.length / itemsPerPage);
            adoptionPagination.innerHTML = '';

            const prevLi = document.createElement('li');
            prevLi.className = `page-item ${adoptionCurrentPage === 1 ? 'disabled' : ''}`;
            prevLi.innerHTML = '<a class="page-link" href="#" aria-label="Previous">&laquo;</a>';
            prevLi.addEventListener('click', () => {
                if (adoptionCurrentPage > 1) {
                    adoptionCurrentPage--;
                    updateAdoptionTable();
                }
            });
            adoptionPagination.appendChild(prevLi);

            for (let i = 1; i <= pageCount; i++) {
                const li = document.createElement('li');
                li.className = `page-item ${i === adoptionCurrentPage ? 'active' : ''}`;
                li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                li.addEventListener('click', () => {
                    adoptionCurrentPage = i;
                    updateAdoptionTable();
                });
                adoptionPagination.appendChild(li);
            }

            const nextLi = document.createElement('li');
            nextLi.className = `page-item ${adoptionCurrentPage === pageCount ? 'disabled' : ''}`;
            nextLi.innerHTML = '<a class="page-link" href="#" aria-label="Next">&raquo;</a>';
            nextLi.addEventListener('click', () => {
                if (adoptionCurrentPage < pageCount) {
                    adoptionCurrentPage++;
                    updateAdoptionTable();
                }
            });
            adoptionPagination.appendChild(nextLi);
        }

        // Report table
        const reportList = document.getElementById('report-list');
        const searchReportInput = document.getElementById('searchReportInput');
        const searchReportButton = document.getElementById('searchReportButton');
        const reportPagination = document.getElementById('reportPagination');
        let reportCurrentPage = 1;
        let filteredReports = [];

        const reports = Array.from(reportList.children);
        filteredReports = reports;
        updateReportTable();

        function performReportSearch() {
            const searchTerm = searchReportInput.value.toLowerCase();
            filteredReports = reports.filter(report => {
                return report.textContent.toLowerCase().includes(searchTerm);
            });
            reportCurrentPage = 1;
            updateReportTable();
        }

        searchReportButton.addEventListener('click', performReportSearch);
        searchReportInput.addEventListener('keyup', function(event) {
            if (event.key === 'Enter') {
                performReportSearch();
            }
        });

        function updateReportTable() {
            const startIndex = (reportCurrentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const pageReports = filteredReports.slice(startIndex, endIndex);

            reportList.innerHTML = '';
            pageReports.forEach(report => reportList.appendChild(report));

            updateReportPagination();
        }

        function updateReportPagination() {
            const pageCount = Math.ceil(filteredReports.length / itemsPerPage);
            reportPagination.innerHTML = '';

            const prevLi = document.createElement('li');
            prevLi.className = `page-item ${reportCurrentPage === 1 ? 'disabled' : ''}`;
            prevLi.innerHTML = '<a class="page-link" href="#" aria-label="Previous">&laquo;</a>';
            prevLi.addEventListener('click', () => {
                if (reportCurrentPage > 1) {
                    reportCurrentPage--;
                    updateReportTable();
                }
            });
            reportPagination.appendChild(prevLi);

            for (let i = 1; i <= pageCount; i++) {
                const li = document.createElement('li');
                li.className = `page-item ${i === reportCurrentPage ? 'active' : ''}`;
                li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                li.addEventListener('click', () => {
                    reportCurrentPage = i;
                    updateReportTable();
                });
                reportPagination.appendChild(li);
            }

            const nextLi = document.createElement('li');
            nextLi.className = `page-item ${reportCurrentPage === pageCount ? 'disabled' : ''}`;
            nextLi.innerHTML = '<a class="page-link" href="#" aria-label="Next">&raquo;</a>';
            nextLi.addEventListener('click', () => {
                if (reportCurrentPage < pageCount) {
                    reportCurrentPage++;
                    updateReportTable();
                }
            });
            reportPagination.appendChild(nextLi);
        }
    });
</script>


<script>
    // Initialize Flatpickr for all datetimepicker inputs
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr('.datetimepicker', {
            enableTime: true,
            dateFormat: "Y-m-d h:i K", // Format with AM/PM
            time_24hr: false
        });
    });

</script>