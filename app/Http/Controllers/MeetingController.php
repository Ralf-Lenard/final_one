<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\AdoptionRequest;
use App\Models\AnimalAbuseReport;
use App\Models\Meeting;
use App\Models\User;
use App\Models\UserMeeting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;



use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Events\MeetingScheduled;
use App\Events\UpdateMeetingScheduled;
use App\Events\MeetingCreate;


use App\Notifications\Meetings;
use App\Notifications\UpdateMeetings;
use App\Notifications\MeetingCreated;


use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;


class MeetingController extends Controller
{
    // Show the list of all approved adoption requests
    public function showApprovedAdoptionRequests()
    {
        // Retrieve all approved adoption requests with related animal data
        // Exclude those that already have a scheduled meeting
        $approvedRequests = AdoptionRequest::with('animalProfile')
            ->where('approved', true)
            ->whereDoesntHave('meeting') // Exclude requests with a scheduled meeting
            ->get();

        $approvedRequestss = AnimalAbuseReport::where('approved', true)
            ->whereDoesntHave('meeting') // Exclude requests with a scheduled meeting
            ->get();


        // Assuming you need the logged-in user ID for each request (if applicable)
        $userId = auth()->id(); // Get the ID of the currently authenticated user

        // Return the view with approved requests and user ID
        return view('admin.Meeting', compact('approvedRequests', 'userId', 'approvedRequestss'));
    }




    // Handle the scheduling of the meeting
    public function scheduleMeeting(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'adoption_request_id' => 'required|exists:adoption_requests,id',
            'user_id' => 'required|exists:users,id',
            'meeting_date' => 'required|date_format:Y-m-d h:i A',
        ]);

        // Convert the date from 12-hour format to 24-hour format for MySQL
        $meetingDate = Carbon::createFromFormat('Y-m-d h:i A', $request->input('meeting_date'))->format('Y-m-d H:i:s');

        // Create a new meeting for adoption requests
        $meeting = new Meeting();
        $meeting->adoption_request_id = $request->input('adoption_request_id');
        $meeting->user_id = $request->input('user_id');
        $meeting->meeting_date = $meetingDate;
        $meeting->status = 'Scheduled';

        try {
            $meeting->save();
            // Trigger the MeetingScheduled event
            event(new MeetingScheduled($meeting));

            // Notify the user
            if ($meeting->user) {
                $meeting->user->notify(new Meetings($meeting));
            } else {
                Log::error('User not found for meeting ID: ' . $meeting->id);
                return response()->json(['success' => false, 'message' => 'User not found'], 404);
            }

            // Redirect back with success message
            return redirect()->route('admin.approved.requests')->with('success', 'Meeting scheduled successfully.');
        } catch (\Exception $e) {
            // Log the error and return an error message
            Log::error('Error scheduling meeting: ' . $e->getMessage());
            return redirect()->back()->withErrors('An error occurred while scheduling the meeting.');
        }
    }


    public function scheduleAbuseMeeting(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'animal_abuse_report_id' => 'required|exists:animal_abuse_reports,id',
            'user_id' => 'required|exists:users,id',
            'meeting_date' => 'required|date_format:Y-m-d h:i A',
        ]);

        // Convert the date to 24-hour format for MySQL
        $meetingDate = Carbon::createFromFormat('Y-m-d h:i A', $request->input('meeting_date'))->format('Y-m-d H:i:s');

        // Create and save the new meeting for animal abuse reports
        $meeting = new Meeting();
        $meeting->animal_abuse_report_id = $request->input('animal_abuse_report_id');
        $meeting->user_id = $request->input('user_id');
        $meeting->meeting_date = $meetingDate;
        $meeting->status = 'Scheduled';

        try {
            $meeting->save();
            // Trigger the MeetingScheduled event
            event(new MeetingScheduled($meeting));

            // Notify the user
            if ($meeting->user) {
                $meeting->user->notify(new Meetings($meeting));
            } else {
                Log::error('User not found for meeting ID: ' . $meeting->id);
                return response()->json(['success' => false, 'message' => 'User not found'], 404);
            }

            // Redirect back with success message
            return redirect()->route('admin.approved.requests')->with('success', 'Meeting scheduled successfully.');
        } catch (\Exception $e) {
            // Log the error and return an error message
            Log::error('Error scheduling meeting: ' . $e->getMessage());
            return redirect()->back()->withErrors('An error occurred while scheduling the meeting.');
        }
    }





    // View the list of all appointments
    public function viewAppointmentList()
    {
        // Retrieve all scheduled appointments with related adoption request data
        $adoptionAppointments = Meeting::with(['adoptionRequest.user', 'adoptionRequest.animalProfile'])
            ->where('meeting_date', '>', now()) // Only get future appointments
            ->whereHas('adoptionRequest', function ($query) {
                $query->where('status', '!=', 'complete'); // Exclude completed adoption requests
            })
            ->orderBy('meeting_date', 'asc')
            ->get();

        // Retrieve all scheduled appointments with related animal abuse report data
        $abuseAppointments = Meeting::with(['animalAbuseReport.user'])
            ->where('meeting_date', '>', now()) // Only get future appointments
            ->whereHas('animalAbuseReport', function ($query) {
                $query->where('status', '!=', 'complete'); // Exclude completed abuse reports
            })
            ->orderBy('meeting_date', 'asc')
            ->get();

        // Return the view with the appointments
        return view('admin.AppointmentList', compact('adoptionAppointments', 'abuseAppointments'));
    }


    // Method to fetch appointments by date
    public function getAppointmentsByDate(Request $request)
    {
        $date = $request->query('date');

        // Fetch meetings scheduled for the selected date
        $adoptionAppointments = Meeting::whereDate('meeting_date', $date)
            ->with(['adoptionRequest.user', 'adoptionRequest.animalProfile'])
            ->whereHas('adoptionRequest', function ($query) {
                $query->where('status', '!=', 'complete'); // Exclude completed adoption requests
            })
            ->orderBy('meeting_date', 'asc')
            ->get();

        $abuseAppointments = Meeting::whereDate('meeting_date', $date)
            ->with(['animalAbuseReport.user'])
            ->whereHas('animalAbuseReport', function ($query) {
                $query->where('status', '!=', 'complete'); // Exclude completed animal abuse reports
            })
            ->orderBy('meeting_date', 'asc')
            ->get();

        // Return the appointments as JSON
        return response()->json([
            'adoptionAppointments' => $adoptionAppointments,
            'abuseAppointments' => $abuseAppointments,
        ]);
    }

    public function getAllAppointments()
    {
        $adoptionAppointments = Meeting::with(['adoptionRequest.user', 'adoptionRequest.animalProfile'])
            ->where('meeting_date', '>', now())
            ->whereHas('adoptionRequest', function ($query) {
                $query->where('status', '!=', 'complete');
            })
            ->orderBy('meeting_date', 'asc')
            ->get();

        $abuseAppointments = Meeting::with(['animalAbuseReport.user']) // This line is correct
            ->where('meeting_date', '>', now())
            ->whereHas('animalAbuseReport', function ($query) {
                $query->where('status', '!=', 'complete');
            })
            ->orderBy('meeting_date', 'asc')
            ->get();


        \Log::info($abuseAppointments);

        return response()->json([
            'adoptionAppointments' => $adoptionAppointments,
            'abuseAppointments' => $abuseAppointments,
        ]);
    }




    public function update(Request $request)
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'meeting_id' => 'required|exists:meetings,id',
            'meeting_date' => 'required|date_format:Y-m-d\TH:i',
        ]);

        // Find the meeting by ID
        $meeting = Meeting::find($validatedData['meeting_id']);

        if (!$meeting) {
            // Return failure response if meeting not found
            return response()->json(['success' => false, 'message' => 'Meeting not found.'], 404);
        }

        // Update the meeting details
        $meeting->meeting_date = $validatedData['meeting_date'];
        $meeting->save();

        // Fire an event to notify about the update
        event(new UpdateMeetingScheduled($meeting));

        // Send notification
        $user = $meeting->user; // Assuming 'user' is the relationship method
        if ($user) {
            $user->notify(new UpdateMeetings($meeting));
        } else {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        // Return success response
        return response()->json(['success' => true, 'message' => 'Meeting updated successfully.']);
    }

   



    public function createVirtualMeetingAdoption(Request $request) 
    { 
        $METERED_DOMAIN = env('METERED_DOMAIN');
        $METERED_SECRET_KEY = env('METERED_SECRET_KEY');
    
        // Logic to create a new meeting
        $response = Http::post("https://{$METERED_DOMAIN}/api/v1/room?secretKey={$METERED_SECRET_KEY}", [
            'autoJoin' => true
        ]);
    
        $roomName = $response->json("roomName");
    
        // Get the current time to compare with meeting dates
        $currentTime = now();
    
        // Fetch upcoming meetings scheduled for today
        // You can adjust this to a specific time frame if needed
        $meetings = Meeting::whereDate('meeting_date', today())
            ->where('meeting_date', '>', $currentTime)
            ->get();
    
        // Notify users linked to those specific meetings
        foreach ($meetings as $meeting) {
            // Get the user ID for each meeting's associated adoption request
            $userId = AdoptionRequest::where('id', $meeting->adoption_request_id)->value('user_id');
    
            // If a valid user ID is found, send the notification
            if ($userId) {
                $user = User::find($userId);
                if ($user) {
                    Notification::send($user, new MeetingCreated($roomName));

                    event(new MeetingCreate($roomName, $userId));
                }
            }
        }
    
        return redirect("/admin-meeting/{$roomName}"); 
    }



    public function createVirtualMeetingAbuse(Request $request) 
    { 
        $METERED_DOMAIN = env('METERED_DOMAIN');
        $METERED_SECRET_KEY = env('METERED_SECRET_KEY');
    
        // Logic to create a new meeting
        $response = Http::post("https://{$METERED_DOMAIN}/api/v1/room?secretKey={$METERED_SECRET_KEY}", [
            'autoJoin' => true
        ]);
    
        $roomName = $response->json("roomName");
    
        // Get the current time to compare with meeting dates
        $currentTime = now();
    
        // Fetch upcoming meetings scheduled for today
        // You can adjust this to a specific time frame if needed
        $meetings = Meeting::whereDate('meeting_date', today())
            ->where('meeting_date', '>', $currentTime)
            ->get();
    
        // Notify users linked to those specific meetings
        foreach ($meetings as $meeting) {
            // Get the user ID for each meeting's associated adoption request
            $userId = AnimalAbuseReport::where('id', $meeting->animal_abuse_report_id)->value('user_id');
    
            // If a valid user ID is found, send the notification
            if ($userId) {
                $user = User::find($userId);
                if ($user) {
                    Notification::send($user, new MeetingCreated($roomName));
                }
            }
        }
    
        return redirect("/admin-meeting/{$roomName}"); 
    }

    public function validateMeeting(Request $request)
    {
        $METERED_DOMAIN = env('METERED_DOMAIN');
        $METERED_SECRET_KEY = env('METERED_SECRET_KEY');

        $meetingId = $request->input('meetingId');

        // Contains logic to validate existing meeting
        $response = Http::get("https://{$METERED_DOMAIN}/api/v1/room/{$meetingId}?secretKey={$METERED_SECRET_KEY}");

        $roomName = $response->json("roomName");


        if ($response->status() === 200) {
            return redirect("/user-meeting/{$roomName}"); // We will update this soon
        } else {
            return redirect("/?error=Invalid Meeting ID");
        }
    }

    public function complete(Request $request, $id)
    {
        // Find the adoption request by ID
        $adoptionRequest = AdoptionRequest::findOrFail($id);

        // Update the status of the adoption request
        $adoptionRequest->status = 'complete';
        $adoptionRequest->save();

        // Assuming that the meeting ID is related to the adoption request
        // Check if the appointment exists based on the adoption request
        $appointment = Meeting::where('adoption_request_id', $id)->first(); // Adjust according to your foreign key setup

        if ($appointment) {
            // Update the status of the appointment
            $appointment->status = 'completed';
            $appointment->save();

            return redirect()->back() // Redirect to the appropriate route
                ->with('success', 'Verification completed successfully and appointment updated.');
        }

        // If the appointment is not found
        return redirect()->route('admin.adoption.requests')
            ->with('error', 'Appointment not found for this adoption request.');
    }

    public function completed(Request $request, $id)
    {
        try {
            // Find the animal abuse report by ID
            $abuseReport = AnimalAbuseReport::findOrFail($id);

            // Update the status of the abuse report
            $abuseReport->status = 'complete';
            $abuseReport->save();

            // Check if the meeting exists based on the abuse report ID
            $appointment = Meeting::where('animal_abuse_report_id', $id)->first();

            if ($appointment) {
                // Update the status of the appointment
                $appointment->status = 'completed';
                $appointment->save();

                return redirect()->back()->with('success', 'Verification completed successfully and appointment updated.');
            }

            // If the appointment is not found
            return redirect()->route('admin.abuses.requests')->with('error', 'Appointment not found for this abuse report.');
        } catch (\Exception $e) {
            // Log the exception message
            \Log::error('Error in MeetingController@completed: ' . $e->getMessage());
            dd($request->all());

            // Redirect with error message
            return redirect()->route('admin.abuses.requests')->with('error', 'An error occurred while completing the verification.');
        }
    }
}
