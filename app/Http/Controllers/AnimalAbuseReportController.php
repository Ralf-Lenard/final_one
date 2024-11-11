<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnimalAbuseReport;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Events\AnimalAbuseReportSubmitted;


use App\Notifications\AbuseVerify;
use App\Notifications\AbuseApprove;
use App\Notifications\AbuseReject;
use App\Notifications\ReportSubmit;

use App\Events\AbusesVerify;
use App\Events\AbusesApprove;
use App\Events\AbusesReject;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AnimalAbuseReportController extends Controller
{
    public function create()
    {


        return view('user.AnimalAbuseReporting');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:1000',
            'photos1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photos2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photos3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photos4' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photos5' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'videos1' => 'nullable|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime|max:1048576',
            'videos2' => 'nullable|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime|max:1048576',
            'videos3' => 'nullable|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime|max:1048576',
        ]);
    
        $report = new AnimalAbuseReport();
        $report->user_id = auth()->id(); // Get the user ID
        $report->description = $request->description;
    
        // Retrieve the user's name from the User model
        $user = auth()->user(); // Get the authenticated user
        if ($user) {
            $report->reporter_name = $user->name; // Set the reporter name
        }
    
        // Handling photos
        for ($i = 1; $i <= 5; $i++) {
            $photoKey = 'photos' . $i;
            if ($request->hasFile($photoKey)) {
                $report->$photoKey = $request->file($photoKey)->store('reports/photos', 'public');
            }
        }
    
        // Handling videos
        for ($i = 1; $i <= 3; $i++) {
            $videoKey = 'videos' . $i;
            if ($request->hasFile($videoKey)) {
                $report->$videoKey = $request->file($videoKey)->store('reports/videos', 'public');
            }
        }
    
        $report->save();
    
        // Broadcast the event with user name
        event(new AnimalAbuseReportSubmitted($report));
    
        // Get the admin user
        $admin = User::where('usertype', 'admin')->first(); 
    
        // Check if the user has three notifications
        if ($admin->notifications()->count() >= 6) {
            // Remove the oldest notification
            $admin->notifications()->oldest()->first()->delete();
        }
    
        // Check if reporter_name is set and then create a notification
        if (isset($report->reporter_name)) {
            $admin->notify(new ReportSubmit([
                'description' => $report->description,
                'reporter_name' => $report->reporter_name, // Use the reporter name correctly
                'message' => 'New Animal Abuse Report submitted by ', // Custom message
            ]));
        } else {
            // Handle the case where reporter_name is not set
            $admin->notify(new ReportSubmit([
                'description' => $report->description,
                'reporter_name' => 'Unknown Reporter', // Default value
                'message' => 'New Animal Abuse Report submitted by Unknown Reporter', // Custom message
            ]));
        }
        
    
        return redirect()->back()->with('success', 'Report submitted successfully.');

    }
    




    public function index()
    {
        $abuses = AnimalAbuseReport::where('approved', false)
            ->where('status', '!=', 'Rejected')
            ->where('status', '!=', 'complete') // Exclude rejected requests
            ->orderBy('created_at', 'desc')
            ->paginate(1000);

        return view('admin.AnimalAbuseReporting', compact('abuses'));
    }






    public function setToVerifying(Request $request, $id)
    {
        $abuses = AnimalAbuseReport::findOrFail($id);
        $abuses->status = 'Verifying';
        $abuses->save();

        event(new AbusesVerify($abuses));

        $abuses->user->notify(new AbuseVerify($abuses));

        return redirect()->route('admin.abuses.requests', ['id' => $id])
            ->with('success', 'The abuse report is now under verification.');
    }

    public function rejectAbuse(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $abuses = AnimalAbuseReport::findOrFail($id);
        $abuses->status = 'Rejected';
        $abuses->approved = false;
        $abuses->reason = $request->input('reason');
        $abuses->admin_id = auth()->user()->id;
        $abuses->handled_by = auth()->id();
        $abuses->save();

        $abuses->user->notify(new AbuseReject($abuses));

        return redirect()->route('admin.abuses.requests')
            ->with('success', 'Abuse report rejected successfully.');
    }

    public function rejectedForm()
    {
        $rejectedRequests = AnimalAbuseReport::with('admin')
            ->where('status', 'Rejected')
            ->orderBy('created_at', 'desc')
            ->paginate(1000);

        return view('admin.RejectedAbuseReport', compact('rejectedRequests'));
    }

    public function approveAbuse($id)
    {
        $abuses = AnimalAbuseReport::findOrFail($id);
        $abuses->status = 'Approved';
        $abuses->approved = true;
        $abuses->handled_by = auth()->id(); // Set the handled_by field
        $abuses->save();
    
        event(new AbusesVerify($abuses));
    
        $abuses->user->notify(new AbuseApprove($abuses));
    
        return redirect()->route('admin.abuses.requests')
            ->with('success', 'Abuse report approved successfully.');
    }
    


    public function completeForm()
    {
        $completeRequests = AnimalAbuseReport::where('status', 'complete')
            ->orderBy('created_at', 'desc')
            ->paginate(1000);

        return view('admin.CompleteAbuse', compact('completeRequests'));
    }
}
