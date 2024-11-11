<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Noah's Ark</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">


    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>

    @vite([ 'resources/js/app.js'])

</head>

<body class="antialiased">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Join Meeting</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('validateMeeting') }}" style="background-color: #faf3e0; padding: 20px; border-radius: 12px; box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);">
                            @csrf

                            <!-- Title -->
                            <h2 class="text-center mb-4" style="color: #6a4a3c;">Join a Meeting</h2>

                            <!-- Meeting ID Input -->
                            <div class="form-group">
                                <label for="meetingId" style="color: #4f3829; font-weight: bold;">Meeting ID</label>
                                <input type="text" name="meetingId" id="meetingId" class="form-control" placeholder="Enter Meeting ID" required style="border: 1px solid #d4a373; border-radius: 8px; color: #4f3829;">

                                <!-- Display validation error if meeting does not exist -->
                                @if ($errors->has('meetingId'))
                                <small class="form-text text-danger">{{ $errors->first('meetingId') }}</small>
                                @endif
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group text-center mt-4">
                                <button type="submit" class="btn" style="background-color: #8b5e34; color: #fff; border-radius: 8px; font-weight: bold;">Join Meeting</button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</body>

</html>