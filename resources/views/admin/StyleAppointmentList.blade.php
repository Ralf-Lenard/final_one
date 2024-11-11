<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: #f3f4f6;
        color: #1f2937;
    }

    .wrapper {
        display: flex;
        min-height: 100vh;
    }

    .sidebar {
        width: 250px;
        background-color: #ffffff;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        padding: 1rem;
        position: fixed;
        height: 100%;
        overflow-y: auto;
    }

    .sidebar h2 {
        font-size: 1.5rem;
        margin-bottom: 2rem;
    }

    .sidebar nav a {
        display: block;
        padding: 0.75rem 1rem;
        color: #4b5563;
        text-decoration: none;
        border-radius: 0.375rem;
        margin-bottom: 0.5rem;
    }

    .sidebar nav a:hover,
    .sidebar nav a.active {
        background-color: #e5e7eb;
    }

    .main-content {
        flex: 1;
        padding: 2rem;
        margin-left: 0px;
        overflow-y: auto;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .header h1 {
        font-size: 2rem;
        margin-left: 250px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
        margin-left: 125px;
    }

    .stat-card {
        background-color: #ffffff;
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-left: 125px;
    }

    .stat-card-header {
        padding: 1rem;
        color: #ffffff;
    }

    .stat-card-body {
        padding: 1rem;
    }

    .stat-card-body h3 {
        font-size: 1.5rem;
        margin-bottom: 0.25rem;
    }

    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .card {
        background-color: #ffffff;
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 1rem;
    }

    .card h2 {
        font-size: 1.25rem;
        margin-bottom: 1rem;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .btn-icon {
        padding: 0.375rem 0.75rem;
    }

    .img-id {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 4px;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .img-id:hover {
        transform: scale(1.1);
    }

    .modal-body img {
        max-width: 100%;
        height: auto;
    }

    /* Dropdown Styles */
    .dropdown {
        position: relative;
        left: 15px;
    }

    .dropdown-btn {
        cursor: pointer;
        display: block;
        padding: 10px;
        color: #fff;
        text-decoration: none;
        margin-bottom: 5px;
        background: #374151;
        border-radius: 4px;
    }

    .dropdown-btn:hover {
        background: #1e293b;
    }

    /* Dropdown Content */
    .sidebar .dropdown-content {
        display: none;
        list-style-type: none;
        padding-left: 0;
        margin-left: 1rem;
    }

    .sidebar .dropdown-content a {
        padding: 0.5rem 1rem;
        text-decoration: none;
        display: block;
        background: #f9fafb;
        border-radius: 0.375rem;
        margin-bottom: 0.25rem;
    }

    .sidebar .dropdown-content a:hover {
        background-color: #e5e7eb;
    }

    /* Show dropdown content on hover or active */
    .sidebar .dropdown:hover .dropdown-content,
    .sidebar .dropdown.active .dropdown-content {
        display: block;
    }

    /* Submenu Styles */
    .sidebar .dropdown-submenu {
        position: relative;
        margin-left: 1rem;
    }

    .sidebar .dropdown-submenu .dropdown-content {
        margin-left: 1rem;
    }

    .card-body {
        margin-left: -10px;
    }

    h2,
    h4 {
        text-align: center;
    }

    #calendar {
        margin: 20px auto;
        height: 5.2in;
        width: 100%;
        cursor: pointer;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
        border: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }

    .highlighted-date {
        background-color: #ffeb3b !important;
        border-radius: 5px;
        color: #000;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.4);
        padding-top: 60px;
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    /* Responsive Styles */
    @media (max-width: 1366px) {
        #calendar {
            height: 4.5in;
            width: 100%; /* Slightly smaller for laptops */
        }

        .stats-grid,
        .content-grid {
            grid-template-columns: 1fr; /* Avoids overlapping of elements */
            gap: 1rem;
        }
    }

    @media (max-width: 1280px) {
        #calendar {
            height: 4in; /* Adjust calendar height */
            width: 100%; /* Adjust width */
            margin: 15px auto;
        }

        .main-content {
            padding: 1rem; /* Reduce padding for content */
        }

        .card {
            margin-bottom: 1rem;
        }
    }

    @media (max-width: 1024px) {
        #calendar {
            height: auto; /* Let it scale naturally */
            width: 100%; /* Use full width within container */
            padding: 10px;
        }

        .stats-grid {
            display: block; /* Stack stat cards vertically */
        }

        .content-grid {
            display: block; /* Ensure non-overlapping content */
        }

        .main-content {
            margin-left: 0; /* Remove margin to fit smaller screens */
        }

        .sidebar {
            width: 220px; /* Slightly smaller sidebar for compact view */
        }

        .header h1 {
            margin-left: 220px; /* Align header with new sidebar size */
        }
    }
</style>
