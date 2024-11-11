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
<script>
    // Enable Pusher logging
    Pusher.logToConsole = true;

    // Initialize Pusher
    var pusher = new Pusher('c27cf1cca7e151dffc12', {
        cluster: 'ap1'
    });

    // Subscribe to the channel
    var channel = pusher.subscribe('animal-profiles');

    // Listen for new animal profile events
    channel.bind('animal-uploaded', function(data) {
        const {
            animal
        } = data;
        const animalList = $('#animal-list');
        animalList.append(`
            <tr id="animal-${animal.id}">
                <td>${animal.name}</td>
                <td>${animal.species}</td>
                <td>${animal.description}</td>
                <td>${animal.age}</td>
                <td>${animal.medical_records}</td>
                <td><img src="${animal.profile_picture}" class="img-thumbnail" alt="${animal.name}"></td>
                <td>
                    <button class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#updateModal${animal.id}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal${animal.id}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `);

        Toastify({
            text: "Animal profile uploaded successfully!",
            duration: 3000,
            gravity: "top",
            position: "right",
            backgroundColor: "#4caf50",
        }).showToast();
    });

    // Listen for delete events
    channel.bind('animal-deleted', function(data) {
        const animalId = data.animalId;
        $(`#animal-${animalId}`).remove();

        Toastify({
            text: "Animal profile deleted successfully!",
            duration: 3000,
            gravity: "top",
            position: "right",
            backgroundColor: "#f44336",
        }).showToast();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const animalList = document.getElementById('animal-list');
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');
        const pagination = document.getElementById('pagination');
        const itemsPerPage = 10;
        let currentPage = 1;
        let filteredAnimals = [];

        // Initialize the table
        const animals = Array.from(animalList.children);
        filteredAnimals = animals;
        updateTable();

        // Search functionality
        function performSearch() {
            const searchTerm = searchInput.value.toLowerCase();
            filteredAnimals = animals.filter(animal => {
                return animal.textContent.toLowerCase().includes(searchTerm);
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
            const pageAnimals = filteredAnimals.slice(startIndex, endIndex);

            animalList.innerHTML = '';
            pageAnimals.forEach(animal => animalList.appendChild(animal));

            updatePagination();
        }

        function updatePagination() {
            const pageCount = Math.ceil(filteredAnimals.length / itemsPerPage);
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
</script>