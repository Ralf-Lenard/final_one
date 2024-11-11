<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noah's Ark</title>
    <style>
        body {
            background-color: #FFFBEB; /* Light beige background */
            font-family: 'Arial', sans-serif;
        }

        .container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .form-container {
            background-color: #fff;
            width: 100%;
            max-width: 400px;
            padding: 32px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .form-container h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 8px;
            color: #5d4037; /* Dark brown */
        }

        .form-container p {
            text-align: center;
            font-size: 14px;
            margin-bottom: 16px;
            color: #7b5b4d; /* Medium brown */
        }

        .input-group {
            margin-bottom: 16px;
        }

        .input-label {
            display: block;
            margin-bottom: 4px;
            font-weight: 600;
            color: #5d4037; /* Dark brown */
        }

        .input-field {
            width: 100%;
            padding: 12px;
            border: 1px solid #bcaaa4; /* Light brown */
            border-radius: 6px;
            font-size: 16px;
        }

        .input-field:focus {
            border-color: #8d6e63; /* Focused dark brown */
            outline: none;
            box-shadow: 0 0 4px rgba(141, 110, 99, 0.3);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 16px;
        }

        .checkbox {
            margin-right: 8px;
        }

        .terms {
            font-size: 14px;
            color: #5d4037; /* Dark brown */
        }

        .button {
            width: 100%;
            padding: 12px;
            background-color: #8d6e63; /* Brown */
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #7b5b4d; /* Darker brown on hover */
        }

        .login-redirect {
            text-align: center;
            margin-top: 12px;
            font-size: 14px;
            color: #5d4037; /* Dark brown */
        }

        .login-redirect a {
            color: #8d6e63; /* Brown link color */
            text-decoration: none;
        }

        .login-redirect a:hover {
            text-decoration: underline;
        }

        .logo {
            display: block;
            margin: 0 auto 16px;
            width: 80px;
            height: 80px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="form-container">
            <img src="{{ asset('logo.jpg') }}" alt="Noah's Ark Logo" class="logo">
            <h2>Create an Account</h2>
            <p>Join us at Noah's Ark and help care for animals in need.</p>

            <form method="POST" action="/register">
                @csrf <!-- Add this line to include the CSRF token -->

                <!-- Name -->
                <div class="input-group">
                    <label for="name" class="input-label">Name</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        class="input-field" 
                        placeholder="Enter your name" 
                        required>
                </div>

                <!-- Email -->
                <div class="input-group">
                    <label for="email" class="input-label">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="input-field" 
                        placeholder="Enter your email" 
                        required>
                </div>

                <!-- Password -->
                <div class="input-group">
                    <label for="password" class="input-label">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="input-field" 
                        placeholder="Enter your password" 
                        required>
                </div>

                <!-- Confirm Password -->
                <div class="input-group">
                    <label for="password_confirmation" class="input-label">Confirm Password</label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        class="input-field" 
                        placeholder="Confirm your password" 
                        required>
                </div>

                <!-- Terms and Privacy Policy -->
                <div class="checkbox-group">
                    <input type="checkbox" id="terms" name="terms" class="checkbox" required>
                    <label for="terms" class="terms">
                        I agree to the <a href="/terms" target="_blank">Terms of Service</a> and 
                        <a href="/policy" target="_blank">Privacy Policy</a>.
                    </label>
                </div>

                <!-- Register Button -->
                <button type="submit" class="button">Register</button>

                <!-- Login Redirect -->
                <p class="login-redirect">
                    Already registered? <a href="/login">Log in</a>
                </p>
            </form>
        </div>
    </div>

</body>

</html>
