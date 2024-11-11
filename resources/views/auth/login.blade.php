<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noah's Ark</title>
    <style>
        body {
            background-color: #FFFBEB;
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
            background-color: #FFFFFF;
            width: 100%;
            max-width: 400px;
            padding: 32px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            color: #5D4037;
            font-weight: bold;
            font-size: 24px;
            margin-bottom: 8px;
            text-align: center;
        }

        .form-container p {
            color: #6D4C41;
            font-size: 14px;
            text-align: center;
        }

        .input-group {
            margin-bottom: 16px;
        }

        .input-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #5D4037;
            margin-bottom: 4px;
        }

        .input-field {
            width: 100%;
            padding: 12px;
            border: 1px solid #8D6E63;
            border-radius: 6px;
            background-color: #EFEBE9;
            color: #3E2723;
            font-size: 16px;
        }

        .input-field:focus {
            outline: none;
            border-color: #6D4C41;
            box-shadow: 0 0 0 2px rgba(109, 76, 65, 0.2);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .checkbox-group label {
            display: flex;
            align-items: center;
            color: #6D4C41;
        }

        .checkbox {
            width: 20px;
            height: 20px;
            margin-right: 8px;
            border: 1px solid #8D6E63;
            background-color: #EFEBE9;
        }

        .button {
            width: 100%;
            background-color: #6D4C41;
            color: #FFFFFF;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 16px;
        }

        .button:hover {
            background-color: #5D4037;
        }

        .form-container a {
            color: #8D6E63;
            text-decoration: none;
        }

        .form-container a:hover {
            color: #6D4C41;
        }

        .register-redirect {
            text-align: center;
            margin-top: 12px;
            font-size: 14px;
            color: #6D4C41;
        }

        .logo {
            display: block;
            margin: 0 auto 16px auto;
            width: 80px;
            height: 80px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="form-container">
        <img src="{{ asset('logo.jpg') }}" alt="Noah's Ark Logo" class="logo">


            <h2>Welcome to Noah's Ark</h2>
            <p>Please sign in to access your account.</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="input-group">
                    <label for="email" class="input-label">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="input-field" 
                        placeholder="Enter your email" 
                        required 
                        autofocus 
                        value="{{ old('email') }}">
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

                <!-- Remember Me and Forgot Password -->
                <div class="checkbox-group">
                    <label>
                        <input type="checkbox" class="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Forgot your password?</a>
                    @endif
                </div>

                <!-- Login Button -->
                <button type="submit" class="button">Log in</button>

                <!-- Register Redirect -->
                <p class="register-redirect">
                    Don’t have an account? <a href="{{ route('register') }}">Sign up</a>
                </p>
            </form>
        </div>
    </div>

</body>
</html>
