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
        /* Fix the sidebar position */
        height: 100%;
        /* Ensure sidebar occupies full height */
        overflow-y: auto;
        /* Add scroll if needed */
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
        height: 100vh;
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
        height: 85vh;
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
        height: 78vh;
    }

    .card-body {
        height: 75vh;
    }

    .card h2 {
        font-size: 1.25rem;
        margin-bottom: 1rem;
    }

    .container-fluid {
        height: 70vh;
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
        /* Indent the dropdown items */
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
        /* Indent the submenu */
    }

    .sidebar .dropdown-submenu .dropdown-content {
        margin-left: 1rem;
        /* Indent the nested submenu */
    }



    @media (max-width: 768px) {
        .wrapper {
            flex-direction: column;
        }

        .sidebar {
            width: 100%;
            position: relative;
            /* Change to relative on smaller screens */
            height: auto;
            /* Allow height to be auto */
        }

        .main-content {
            margin-left: 0;
            /* Reset margin on smaller screens */
        }

        .content-grid {
            grid-template-columns: 1fr;
        }
    }
</style>