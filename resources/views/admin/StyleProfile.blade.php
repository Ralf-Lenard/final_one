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
        color: #4b5563;
    }

    .sidebar nav a {
        display: block;
        padding: 0.75rem 1rem;
        color: #4b5563;
        text-decoration: none;
        border-radius: 0.375rem;
        margin-bottom: 0.5rem;
        transition: background-color 0.3s;
    }

    .sidebar nav a:hover,
    .sidebar nav a.active {
        background-color: #e5e7eb;
    }

    .main-content {
        flex: 1;
        padding: 2rem;
        margin-left: 250px;
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
    }

    .user-profile {
        background-color: #ffffff;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .user-profile-content {
        display: flex;
        padding: 2rem;
    }

    .user-profile-left {
        flex: 1;
        padding-right: 2rem;
        border-right: 1px solid #e5e7eb;
        
    }

    .user-profile-right {
        flex: 2;
        padding-left: 2rem;
       
    }

    .user-avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 1rem;
        border: 2px solid #e5e7eb;
        /* Add border for avatar */
    }

    .user-info {
        margin-bottom: 1rem;
    }

    .user-info h2 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }

    .user-info p {
        color: #6b7280;
        margin-bottom: 0.25rem;
    }


    .personal-info h3 {
        font-size: 1.25rem;
        margin-bottom: 1rem;

    }

    .tt {
        margin-top: 50px;
        font-size: 1.25rem;
    }

    .info-item {
        display: flex;
        margin-bottom: 1rem;
    }

    .info-label {
        font-weight: 600;
        width: 120px;
    }

    .info-value {
        flex: 1;
    }

    .online-status-dot {
        display: inline-block;
        width: 10px;
        height: 10px;
        background-color: green;
        border-radius: 50%;
        margin-left: 5px;
        z-index: 100;
    }

    /* Table Styling */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    th,
    td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
    }

    th {
        background-color: #f9fafb;
        font-weight: bold;
        color: #374151;
    }

    tr:hover {
        background-color: #f1f5f9;
        /* Hover effect for table rows */
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

    .user-profile-right {
    position: relative;
    padding: 20px;
}

.edit-profile {
    position: absolute;
    top: 10px;
    right: 10px;
}





    @media (max-width: 768px) {
        .wrapper {
            flex-direction: column;
        }

        .sidebar {
            width: 100%;
            position: relative;
            height: auto;
        }

        .main-content {
            margin-left: 0;
        }

        .user-profile-content {
            flex-direction: column;
        }

        .user-profile-left {
            border-right: none;
            border-bottom: 1px solid #e5e7eb;
            padding-right: 0;
            padding-bottom: 2rem;
            margin-bottom: 2rem;
        }

        .user-profile-right {
            padding-left: 0;
        }

        table {
            display: block;
            overflow-x: auto;
            /* Horizontal scrolling for smaller screens */
            white-space: nowrap;
            /* Prevent text wrapping */
        }
    }
</style>