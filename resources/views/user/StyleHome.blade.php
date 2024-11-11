<!-- <style>
  .unread_message {
    position: absolute;
    top: -5px;
    right: -5px;
    background-color: red;
    color: white;
    width: 18px;
    height: 18px;
    font-size: 12px;
    font-weight: bold;
    text-align: center;
    line-height: 18px;
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
} -->


</style>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f0f4f8;
    }
    .navbar {
        background-color: black;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 1rem 0;
    }
    .navbar-brand {
        color: #2c3e50;
        font-weight: 600;
        font-size: 1.5rem;
    }
    .nav-link {
        color: #34495e;
        font-weight: 400;
        transition: all 0.3s ease;
        position: relative;
        font-size: 1.1rem;
    }
    .nav-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: -2px;
        left: 0;
        background-color: #3498db;
        transition: width 0.3s ease;
    }
    .nav-link:hover::after {
        width: 100%;
    }
    .btn-primary {
        background-color: #3498db;
        border-color: #3498db;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #2980b9;
        border-color: #2980b9;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .btn-outline-primary {
        color: #3498db;
        border-color: #3498db;
        transition: all 0.3s ease;
    }
    .btn-outline-primary:hover {
        background-color: #3498db;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .hero {
        background: linear-gradient(rgba(52, 152, 219, 0.8), rgba(52, 152, 219, 0.8)), url('https://images.unsplash.com/photo-1548199973-03cce0bbc87b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 120px 0;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    .hero::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0) 80%);
        animation: pulse 15s linear infinite;
    }
    @keyframes pulse {
        0% { transform: translate(0, 0); }
        100% { transform: translate(50%, 50%); }
    }
    .hero h1 {
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 3rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }
    .hero p {
        font-weight: 300;
        font-size: 1.2rem;
        max-width: 600px;
        margin: 0 auto;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
    }
    .nav-icon {
        font-size: 1.8rem;
        color: #34495e;
        margin-left: 20px;
        transition: all 0.3s ease;
        position: relative;
    }
    .nav-icon:hover {
        color: #3498db;
    }
    .nav-icon::after {
        content: '';
        position: absolute;
        width: 40px;
        height: 40px;
        background-color: rgba(52, 152, 219, 0.1);
        border-radius: 50%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0);
        transition: transform 0.3s ease;
    }
    .nav-icon:hover::after {
        transform: translate(-50%, -50%) scale(1);
    }
    .nav-buttons {
        display: flex;
        align-items: center;
    }
    .nav-buttons .btn {
        margin-left: 15px;
    }
    .content-section {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        margin-bottom: 2rem;
    }
    .content-section h2 {
        color: #2c3e50;
        margin-bottom: 1rem;
        font-weight: 600;
    }
    .content-section p {
        color: #34495e;
        line-height: 1.6;
    }
    @media (max-width: 991px) {
        .nav-icon-group, .nav-buttons {
            margin-top: 15px;
        }
        .nav-buttons {
            flex-direction: column;
            align-items: flex-start;
        }
        .nav-buttons .btn {
            margin-left: 0;
            margin-top: 10px;
        }
        .nav-icon {
            margin-left: 0;
            margin-right: 20px;
        }
    }
</style>
