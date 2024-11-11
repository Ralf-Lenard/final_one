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

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="antialiased">

    <div class="d-flex justify-content-center align-items-center" style="height: 30px;">
        <form method="post" action="{{ route('createMeetingAdoption') }}">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-primary"><i class="fas fa-video"></i></button>
        </form>
    </div>

</body>

</html>