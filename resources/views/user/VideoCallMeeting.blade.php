<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Noah's Ark</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.metered.ca/sdk/video/1.4.5/sdk.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
   

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    }
                }
            }
        };
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

   

    <script>
        window.METERED_DOMAIN = "{{ $METERED_DOMAIN }}";
        window.MEETING_ID = "{{ $MEETING_ID }}";
    </script>


</head>

<body class="antialiased bg-gray-100 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div id="waitingArea">

            <div class="max-w-2xl mx-auto mt-8 flex flex-col space-y-6" id="max">
                <div class="flex items-center justify-center w-full rounded-2xl bg-gray-900 overflow-hidden">
                    <video id="waitingAreaLocalVideo" class="h-96 w-full object-cover" autoplay muted></video>
                </div>
                <div class="flex space-x-4 justify-center">
                    <button id="waitingAreaToggleMicrophone" class="bg-blue-500 hover:bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                        </svg>
                    </button>
                    <button id="waitingAreaToggleCamera" class="bg-blue-500 hover:bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div class="space-y-2">
                        <label for="username" class="block font-medium text-gray-700">Name:</label>
                        <input id="username" type="text" value="{{ $USER_NAME }}" placeholder="Name" readonly class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                    </div>
                    <div class="space-y-2">
                        <label for="cameraSelectBox" class="block font-medium text-gray-700">Camera:</label>
                        <select id="cameraSelectBox" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label for="microphoneSelectBox" class="block font-medium text-gray-700">Microphone:</label>
                        <select id="microphoneSelectBox" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </select>
                    </div>
                </div>
                <div class="flex justify-center">
                    <button id="joinMeetingBtn" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300 ease-in-out">
                        Join Meeting
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="meetingView" class="hidden fixed inset-0 bg-gray-100 flex flex-col md:flex-row">
    <!-- Left Section (Video Feed) -->
    <div class="flex-1 flex p-4">
        <div id="activeSpeakerContainer" 
             class="bg-gray-900 rounded-3xl flex-1 relative overflow-hidden">
            <video id="activeSpeakerVideo" src="" 
                   autoplay 
                   class="object-cover w-full h-full rounded-3xl"></video>
            <div id="activeSpeakerUsername" 
                 class="hidden absolute bottom-0 w-full bg-gray-800 bg-opacity-75 rounded-b-3xl text-white text-center font-bold py-2">
            </div>
        </div>
    </div>

    <!-- Right Section (Participants and Controls) -->
    <div class="w-full md:w-64 p-4 bg-white shadow-lg flex flex-col">
        <!-- Participants List -->
        <div id="remoteParticipantContainer" class="flex-1 overflow-y-auto space-y-4">
            <div id="localParticipantContainer" 
                 class="w-full aspect-video rounded-2xl bg-gray-900 relative overflow-hidden">
                <video id="localVideoTag" src="" 
                       autoplay 
                       class="object-cover w-full h-full rounded-2xl"></video>
                <div id="localUsername" 
                     class="absolute bottom-0 w-full bg-gray-800 bg-opacity-75 rounded-b-2xl text-white text-center font-bold py-1">
                    Me
                </div>
            </div>
        </div>

        <!-- Control Buttons -->
        <div class="flex justify-between mt-4">
            <button id="toggleMicrophone" 
                    class="bg-blue-500 hover:bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                </svg>
            </button>

            <button id="toggleCamera" 
                    class="bg-blue-500 hover:bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
            </button>

            <button id="toggleScreen" 
                    class="bg-blue-500 hover:bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </button>

            <button id="leaveMeeting" 
                    class="bg-red-500 hover:bg-red-600 text-white w-12 h-12 rounded-full flex items-center justify-center transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </button>
        </div>
    </div>
</div>


    @include('admin.LeaveMeeting')
    </div>
    </div>
</body>

</html>