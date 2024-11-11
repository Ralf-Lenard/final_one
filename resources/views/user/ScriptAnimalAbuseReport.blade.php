<style>
    .form-group {
        margin-bottom: 1rem;
    }
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }
        .full-height {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa; /* Light background color */
        }
        .form-container {
            width: 100%;
            max-width: 600px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .form-container h2 {
            margin-bottom: 1rem;
            font-size: 1.5rem;
            color: #333;
        }
        .form-container .form-group {
            margin-bottom: 1rem;
        }
        .form-container .form-control {
            border-radius: 5px;
            border: 1px solid #ced4da;
            padding: 0.75rem 1.25rem;
            font-size: 1rem;
        }
        .form-container .btn {
            border-radius: 5px;
            padding: 0.75rem 1.25rem;
            font-size: 1rem;
        }
        .form-container .btn-primary {
            background-color: #007bff;
            border: none;
            color: #ffffff;
        }
        .form-container .btn-primary:hover {
            background-color: #0056b3;
        }
        .form-container .btn-secondary {
            background-color: #6c757d;
            border: none;
            color: #ffffff;
        }
        .form-container .btn-secondary:hover {
            background-color: #5a6268;
        }


    /* Ensuring navbar is on top */
    .navbar {
      z-index: 1000; /* High z-index to avoid overlap */
    }
  
    </style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const maxPhotos = 5;  // Maximum number of photo inputs allowed
        const maxVideos = 3;  // Maximum number of video inputs allowed

        // Function to handle dynamic input addition
        function handleFileInputChange(input, container, maxFiles) {
            const currentInputs = container.querySelectorAll('input[type="file"]').length;
            if (input.files.length > 0 && currentInputs < maxFiles) {
                const nextInput = currentInputs + 1;  // Next input index
                if (nextInput <= maxFiles) {
                    const newId = input.id.replace(/[0-9]+$/, '') + nextInput;
                    const label = input.id.includes('photos') ? `Upload Photo ${nextInput}` : `Upload Video ${nextInput}`;
                    // Add a new file input to the container
                    container.insertAdjacentHTML('beforeend', `
                        <div class="form-group">
                            <label for="${newId}">${label}</label>
                            <input type="file" class="form-control" id="${newId}" name="${newId}" accept="${input.getAttribute('accept')}">
                        </div>
                    `);
                }
            }
        }

        // Listen for changes in the photo inputs container
        document.getElementById('photoInputs').addEventListener('change', function (e) {
            if (e.target.matches('input[type="file"]')) {
                handleFileInputChange(e.target, this, maxPhotos);
            }
        });

        // Listen for changes in the video inputs container
        document.getElementById('videoInputs').addEventListener('change', function (e) {
            if (e.target.matches('input[type="file"]')) {
                handleFileInputChange(e.target, this, maxVideos);
            }
        });
    });
</script>
