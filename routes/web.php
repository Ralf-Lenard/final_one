<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Middleware;


use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnimalProfileController;
use App\Http\Controllers\AnimalAbuseReportController;
use App\Http\Controllers\AdoptionRequestController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PusherAuthController;
use App\Http\Controllers\UserManagingController;
use App\Http\Controllers\ProfileController;

use App\Events\AnimalProfileCreated;
use App\Models\AnimalProfile;

// Route for the admin homepage
Route::get('/profile', [HomeController::class, 'profile'])->middleware('auth')->name('profile.show');

// User homepage
Route::get('/home', [HomeController::class, 'userHomepage'])->name('user.home')->middleware('auth');

Route::get('/profile', [ProfileController::class, 'Profile'])
    ->middleware('auth')
    ->name('profile.show');

Route::middleware(['admin'])->group(function () {
    Route::get('admin-profile/edit', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::put('admin-profile/update', [ProfileController::class, 'update'])->name('admin.profile.update');
});

Route::get('/animals/search', [HomeController::class, 'search'])->name('animals.search')->middleware('auth');;


// Animal profile uploading
// Route to store a newly created animal profile (User)
Route::post('/animal-profiles/store', [AnimalProfileController::class, 'store'])->name('animal-profiles.store');

// Route to list all animal profiles (Admin)
Route::get('/animal-profiles', [AnimalProfileController::class, 'list'])->name('admin.animal-profile-list')->middleware('admin');

Route::get('/animal-locations', [AnimalProfileController::class, 'gpsView'])->name('admin.gps')->middleware('admin');

// Admin routes for animal profile management
Route::middleware(['admin'])->group(function () {
    // Delete animal and update
    Route::post('/update-animal/{id}', [AnimalProfileController::class, 'update']);
    Route::post('/delete-animal/{id}', [AnimalProfileController::class, 'destroy']);
});

// Animal view profile
Route::get('/animals/{id}', [HomeController::class, 'show'])->name('animals.show');

// Adoption routes
// User adoption request
Route::get('/adopt/{animalprofile}/request', [AdoptionRequestController::class, 'showAdoptionForm'])->name('adopt.show');
Route::post('/adopt/{id}/request', [AdoptionRequestController::class, 'submitAdoptionRequest'])->name('adoption.submit');

// Admin adoption request management
Route::middleware(['admin'])->group(function () {
    Route::get('/adoption-requests', [AdoptionRequestController::class, 'submitted'])->name('admin.adoption.requests');
    Route::post('/adoption-request/{id}/approve', [AdoptionRequestController::class, 'approveAdoption'])->name('admin.adoption.approve');
    Route::post('/adoption/{id}/reject', [AdoptionRequestController::class, 'rejectAdoption'])->name('admin.adoption.reject');
    Route::get('/rejected-Form', [AdoptionRequestController::class, 'rejectedForm']);
    Route::post('/adoption/requests/{id}/verify', [AdoptionRequestController::class, 'setToVerifying'])->name('admin.adoption.verify');
    Route::get('/completed-adoption', [AdoptionRequestController::class, 'completeAdoption']);
});

// Animal abuse report routes
// User report creation
Route::get('/report/abuse', [AnimalAbuseReportController::class, 'create'])->name('report.abuses.form');
Route::post('/report/abuse', [AnimalAbuseReportController::class, 'store'])->name('report.abuses.submit');

// Admin report management
Route::middleware(['admin'])->group(function () {
    Route::get('/reports', [AnimalAbuseReportController::class, 'index'])->name('admin.abuses.requests');
    Route::post('/reports/{id}/verify', [AnimalAbuseReportController::class, 'setToVerifying'])->name('admin.abuses.verify');
    Route::post('/reports/{id}/approve', [AnimalAbuseReportController::class, 'approveAbuse'])->name('admin.abuses.approve');
    Route::post('/reject/{id}', [AnimalAbuseReportController::class, 'rejectAbuse'])->name('admin.abuses.reject');
    Route::get('/rejected', [AnimalAbuseReportController::class, 'rejectedForm'])->name('admin.abuses.rejected');
    Route::post('/reports/{id}/complete', [AnimalAbuseReportController::class, 'complete'])->name('admin.abuses.complete');
    Route::get('/completed/Animal-Abuse-Report', [AnimalAbuseReportController::class, 'completeForm']);
});

// Meeting routes (Admin)
Route::middleware(['admin'])->group(function () {
    Route::get('/approved-requests', [MeetingController::class, 'showApprovedAdoptionRequests'])->name('admin.approved.requests');
    Route::get('/schedule-meeting/{id}', [MeetingController::class, 'showScheduleMeetingForm'])->name('admin.schedule.meeting.form');
    Route::post('/schedule-meeting', [MeetingController::class, 'scheduleMeeting'])->name('admin.schedule.meeting');
    Route::post('/schedule-meeting-abuses', [MeetingController::class, 'scheduleAbuseMeeting'])->name('admin.scheduleAbuse.meeting');
    Route::get('/appointments', [MeetingController::class, 'viewAppointmentList'])->name('admin.appointments.list');
    Route::get('/appointments/by-date', [MeetingController::class, 'getAppointmentsByDate'])->name('admin.appointments.byDate');
    Route::get('/appointments/all', [MeetingController::class, 'getAllAppointments'])->name('admin.appointments.all');
    Route::post('/meeting/update', [MeetingController::class, 'update'])->name('admin.meeting.update');
    Route::post('/adoption/requests/{id}/complete', [MeetingController::class, 'complete'])->name('admin.adoption.complete');
    Route::post('/abuses/requests/{id}/complete', [MeetingController::class, 'completed'])->name('admin.abuses.complete');
});

// User managing routes (Admin)
Route::middleware(['master'])->group(function () {
    Route::post('/users{id}/make-admin', [UserManagingController::class, 'makeAdmin'])->name('users.makeAdmin');
    Route::post('/users{id}/make-user', [UserManagingController::class, 'makeUser'])->name('users.makeUser');
    Route::delete('/users/{id}', [UserManagingController::class, 'destroy'])->name('users.destroy');
    Route::get('/users', [UserManagingController::class, 'user'])->name('users.List');
    Route::get('/admins', [UserManagingController::class, 'admin'])->name('admins.List');
    Route::get('/user-profile/{id}', [UserManagingController::class, 'viewUserProfile'])->name('user.profile.view');
    Route::get('/admin-profile/{id}', [UserManagingController::class, 'viewAdminProfile'])->name('admin.profile.view');
});


// User notification
Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
Route::get('/notifications', [NotificationController::class, 'index'])->middleware('auth')->name('notifications.index');


// Message routes
// Admin messaging


// Admin Messenger Route
Route::get('/admin-messenger', [MessageController::class, 'adminMessage'])
    ->name('admin.Message')
    ->middleware(['auth', 'admin']); // Ensure admin is authenticated

// User Messenger Route
Route::get('/user-messenger', [MessageController::class, 'userMessage'])
    ->name('user.Message')
    ->middleware(['auth']); // Users need to be authenticated

// Master Messenger Route
Route::get('/master-messenger', [MessageController::class, 'masterMessage'])
    ->name('Master.Message')
    ->middleware(['auth', 'master']); // Ensure master is authenticated

// Redirect user to the correct messenger page based on their role
Route::get('/messenger/{id}', [MessageController::class, 'chatWithUser'])
    ->name('messenger.chat') // Named route for user chat
    ->middleware(['auth']); // Users need to be authenticated

Route::get('/chatify/{id}', [MessageController::class, 'chatWithAdmin'])
    ->name('admin.chat') // Named route for admin chat
    ->middleware(['auth', 'admin']); // Only authenticated admins can access

Route::get('/master-chat/{id}', [MessageController::class, 'chatWithMaster'])
    ->name('master.chat') // Named route for master chat
    ->middleware(['auth', 'master']); // Only authenticated masters can access




Route::post("/createMeetingAdoption", [MeetingController::class, 'createVirtualMeetingAdoption'])->name("createMeetingAdoption");
Route::post("/createMeetingAbuse", [MeetingController::class, 'createVirtualMeetingAbuse'])->name("createMeetingAbuse");
Route::post("/validateMeeting", [MeetingController::class, 'validateMeeting'])->name("validateMeeting");

// Meeting view for admin
Route::middleware(['admin'])->get("/admin-meeting/{meetingId}", function ($meetingId) {
    $METERED_DOMAIN = env('METERED_DOMAIN');
    $userName = auth()->user()->name; // Get the authenticated user's name

    return view('admin.VideoCallMeeting', [
        'METERED_DOMAIN' => $METERED_DOMAIN,
        'MEETING_ID' => $meetingId,
        'USER_NAME' => $userName,

    ]);
})->name('admin.meeting');



// Meeting view for user
Route::middleware(['auth'])->get("/user-meeting/{meetingId}", function ($meetingId) {
    $METERED_DOMAIN = env('METERED_DOMAIN');
    $userName = auth()->user()->name; // Get the authenticated user's name

    return view('user.VideoCallMeeting', [
        'METERED_DOMAIN' => $METERED_DOMAIN,
        'MEETING_ID' => $meetingId,
        'USER_NAME' => $userName // Pass the user's name to the view
    ]);
});

// Admin video call view
Route::middleware(['admin'])->get('/Admin-Video-call', function () {
    return view('admin.VideoCall');
});

// User video call view
Route::middleware(['auth'])->get('/User-Video-call', function () {
    return view('user.VideoC');
})->name('user.video-call');



// Welcome page
Route::get('/', function () {
    $animals = AnimalProfile::latest()->take(6)->get();
    return view('welcome', compact('animals'));
});




// message counting
Route::get('unreadcount', function () {
    $count = auth()->user()->getMessageCount();
    return response()->json(['count' => $count]);
})->name('unreadcount');
