<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noah's Ark</title>
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            color: #2e1a0f;
            background-color: #f8f3ed;
        }

        /* Main Container */
        .authentication-card {
            background-color: #ffffff; /* White background for the card */
            border-radius: 8px;
            padding: 2rem;
            max-width: 400px;
            margin: 2rem auto;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Text Styling */
        .text-center {
            text-align: center;
        }

        .text-gray {
            color: #6b7280; /* Gray text */
        }

        .text-green {
            color: #4ade80; /* Green text for success messages */
        }

        /* Input Styles */
        .input-field {
            width: 100%;
            padding: 0.75rem;
            margin: 1rem 0;
            border: 1px solid #8b5e34; /* Border color */
            border-radius: 4px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .input-field:focus {
            border-color: #704a2b; /* Darker border on focus */
            box-shadow: 0 0 0 1px #704a2b; /* Focused shadow */
        }

        /* Button Styles */
        .button {
            background-color: #8b5e34; /* Button color */
            color: #ffffff; /* Button text color */
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 1rem;
        }

        .button:hover {
            background-color: #704a2b; /* Button hover color */
        }
    </style>
</head>
<body>

<div class="authentication-card">
    <h2 class="text-center">Forgot Your Password?</h2>
    <p class="text-center text-gray">
        No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
    </p>

    @session('status')
        <div class="text-center text-green">
            {{ $value }}
        </div>
    @endsession

    <x-validation-errors class="mb-4" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <label for="email" class="text-gray">Email</label>
            <input id="email" class="input-field" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
        </div>

        <div class="text-center">
            <button type="submit" class="button">
                Email Password Reset Link
            </button>
        </div>
    </form>
</div>

</body>
</html>
