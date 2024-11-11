import jquery from 'jquery';

/**
 * Detect if the user is on a mobile device
 */
function isMobileDevice() {
    const userAgent = navigator.userAgent || navigator.vendor || window.opera;
    return /android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(userAgent.toLowerCase());
}

/**
 * Request camera access with media constraints
 */
async function requestCameraAccess() {
    try {
        const videoElement = document.getElementById("waitingAreaLocalVideo");
        if (!videoElement) {
            console.error("Video element not found!");
            return; // Exit the function if the element does not exist
        }

        const stream = await navigator.mediaDevices.getUserMedia({
            video: { facingMode: "user" }, // Front-facing camera
        });

        videoElement.srcObject = stream;
        videoElement.play();
        console.log("Camera access granted.");
    } catch (error) {
        console.error("Camera access failed:", error);
        alert("Unable to access camera. Please check permissions.");
    }
}

/**
 * Initialize mobile camera options
 */
async function initializeMobileCameraOptions() {
    if (!isMobileDevice()) return;

    try {
        const devices = await navigator.mediaDevices.enumerateDevices();
        const videoDevices = devices.filter(device => device.kind === 'videoinput');

        const options = videoDevices.map(
            device => `<option value="${device.deviceId}">${device.label}</option>`
        );

        jquery("#mobileCameraSelectBox").html(options.join(""));
        console.log("Mobile camera options initialized.");
    } catch (error) {
        console.error("Error initializing mobile camera options:", error);
    }
}

/**
 * Orientation change listener for mobile devices
 */
window.addEventListener("orientationchange", () => {
    if (isMobileDevice()) {
        alert("Orientation changed! Adjust your camera.");
    }
});

/**
 * Initialize mobile support for the meeting
 */
function initializeMobileSupport(meeting) {
    // Implementation logic for initializing mobile support
    console.log('Mobile support initialized for the meeting:', meeting);
    // Add any additional setup code needed here
}

export { 
    isMobileDevice, 
    initializeMobileCameraOptions, 
    requestCameraAccess, 
    initializeMobileSupport // Add this export
};
