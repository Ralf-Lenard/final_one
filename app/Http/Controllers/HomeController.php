<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AdoptionRequest;
use App\Models\AnimalProfile;
use App\Models\AnimalAbuseReport;
use App\Models\Meeting;
use Carbon\Carbon;
use Illuminate\Notifications\Notification;

class HomeController extends Controller
{
    /**
     * Display the appropriate homepage based on user type.
     */
    public function userHomepage(Request $request)
    {
        $user = Auth::user();

        if ($user->usertype === 'user') {
            // Fetch animal profiles
            $animalProfiles = AnimalProfile::where('is_adopted', false)
                ->orderBy('created_at', 'desc')
                ->paginate(1000);

            // Fetch user notifications

            // Pass the variables to the view
            return view('user.home', compact('animalProfiles'));
        } elseif ($user->usertype === 'admin') {
            $totalAnimals = AnimalProfile::where('is_adopted', false)->count();
            $pendingAdoptions = AdoptionRequest::whereIn('status', ['pending', 'approved', 'Verifying'])->count();
            $pendingAbuses = AnimalAbuseReport::whereIn('status', ['pending', 'Approved', 'Verifying'])->count();
            $upcomingMeetings = Meeting::where('meeting_date', '>', Carbon::now())->count();

            $newAdoptionRequests = AdoptionRequest::where('status', 'pending')->count();

            // unread message
            //  $unreadMessages = Message::where('read', false)->count();

            $upcomingMeetings = Meeting::where('meeting_date', '>=', Carbon::today())
                ->where('meeting_date', '<=', Carbon::today()->endOfDay())
                ->where('status', '!=', 'completed') // Exclude completed meetings
                ->count();


            $recentAbuseReports = AnimalAbuseReport::latest()->take(3)->get();

            // Fetch recent adoption requests
            $recentAdoptions = AdoptionRequest::with('animal')->latest()->take(3)->get();

            // Fetch recent animals added
            $recentAnimals = AnimalProfile::latest()->take(3)->get();

            $recentActivities = [];

            // Add abuse reports first
            foreach ($recentAbuseReports as $report) {
                $recentActivities[] = [
                    'type' => 'abuse_report',
                    'message' => 'Animal abuse report filed',
                    'date' => $report->created_at->format('Y-m-d'),
                    'timestamp' => $report->created_at,
                ];
            }

            // Add adoption requests
            foreach ($recentAdoptions as $adoption) {
                $recentActivities[] = [
                    'type' => 'adoption_request',
                    'message' => 'Adoption request for ' . $adoption->animal->name,
                    'date' => $adoption->created_at->format('Y-m-d'),
                    'timestamp' => $adoption->created_at,
                ];
            }

            // Add new animals
            foreach ($recentAnimals as $animal) {
                $recentActivities[] = [
                    'type' => 'new_animal',
                    'message' => 'New animal added: ' . $animal->name . ' the ' . $animal->species,
                    'date' => $animal->created_at ? $animal->created_at->format('Y-m-d') : 'N/A',
                    'timestamp' => $animal->created_at,
                ];
            }

            // Debugging: Check the content of recentActivities before sorting
            \Log::info($recentActivities);

            // Sort activities: prioritize abuse reports first, then by creation date descending
            usort($recentActivities, function ($a, $b) {
                // First, check if the types are different (prioritize abuse_report)
                if ($a['type'] === 'abuse_report' && $b['type'] !== 'abuse_report') {
                    return -1; // $a comes first
                } elseif ($a['type'] !== 'abuse_report' && $b['type'] === 'abuse_report') {
                    return 1; // $b comes first
                } else {
                    // If both are the same type, sort by timestamp (newest first)
                    return $b['timestamp'] <=> $a['timestamp'];
                }
            });



            $adoptionData = AdoptionRequest::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
                ->where('status', 'complete') // Assuming you track the status of the request
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get();

            // Define months in proper order (Jan -> Dec)
            $allMonths = [
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'
            ];

            $adoptionRate = [];
            $months = [];

            // Loop through the data and push the adoption counts and months into arrays
            foreach ($adoptionData as $data) {
                $adoptionRate[] = $data->count;
                $months[] = Carbon::create()->month($data->month)->format('F'); // Month names
            }

            // Get the current month index
            $currentMonth = Carbon::now()->month;

            // Rearrange months so the chart starts from the current month
            $rearrangedMonths = array_merge(
                array_slice($allMonths, $currentMonth - 1), // From current month to end
                array_slice($allMonths, 0, $currentMonth - 1) // From start to the current month
            );

            // Rearrange adoption data according to the new order of months
            $rearrangedAdoptionRate = [];
            foreach ($rearrangedMonths as $month) {
                $index = array_search($month, $months);
                $rearrangedAdoptionRate[] = $index !== false ? $adoptionRate[$index] : 0; // Add count or 0 if no data
            }










            // Initialize arrays for intake and adoption data
            $intakeData = array_fill(0, 12, 0); // Start with 0 for each month
            $adoptionData = array_fill(0, 12, 0); // Start with 0 for each month

            // Loop through the months to get intake and adoption counts
            foreach ($months as $index => $month) {
                // Get month number (1-12)
                $monthNumber = $index + 1;

                // Fetch intake count for the month
                $intakeData[$index] = AnimalProfile::whereMonth('created_at', $monthNumber)->count();

                // Fetch adoption count for the month
                $adoptionData[$index] = AdoptionRequest::whereMonth('created_at', $monthNumber)->count();
            }

            // Assuming the admin is authenticated
            $admin = $request->user();

            // If you want to retrieve all notifications (you can also limit them)
            $notifications = $admin->notifications()->latest()->take(3)->get();


            return view('admin.home', compact(
                'totalAnimals',
                'pendingAdoptions',
                'pendingAbuses',
                'upcomingMeetings',
                'newAdoptionRequests',
                'upcomingMeetings',
                'recentActivities',
                'rearrangedAdoptionRate',
                'rearrangedMonths',
                'months',
                'intakeData',
                'adoptionData',
                'notifications'
            ));
        } elseif ($user->usertype === 'master') {

            $users = User::where('usertype', 'user')->get(); // Retrieve users with 'user' type
            $admins = User::where('usertype', 'admin')->get();

            $adoptionData = AdoptionRequest::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
                ->where('status', 'complete') // Assuming you track the status of the request
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get();

            // Define months in proper order (Jan -> Dec)
            $allMonths = [
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'
            ];

            $adoptionRate = [];
            $months = [];

            // Loop through the data and push the adoption counts and months into arrays
            foreach ($adoptionData as $data) {
                $adoptionRate[] = $data->count;
                $months[] = Carbon::create()->month($data->month)->format('F'); // Month names
            }

            // Get the current month index
            $currentMonth = Carbon::now()->month;

            // Rearrange months so the chart starts from the current month
            $rearrangedMonths = array_merge(
                array_slice($allMonths, $currentMonth - 1), // From current month to end
                array_slice($allMonths, 0, $currentMonth - 1) // From start to the current month
            );

            // Rearrange adoption data according to the new order of months
            $rearrangedAdoptionRate = [];
            foreach ($rearrangedMonths as $month) {
                $index = array_search($month, $months);
                $rearrangedAdoptionRate[] = $index !== false ? $adoptionRate[$index] : 0; // Add count or 0 if no data
            }






            $totalAnimals = AnimalProfile::where('is_adopted', false)->count();

            $admins = User::where('usertype', 'admin')->count();

            $regularUsers = User::where('usertype', 'user')->count();

            $adoptionRequest = AdoptionRequest::all()->count();

            $abuseReport = AnimalAbuseReport::all()->count();






            return view('Master.MasterAdmin', compact(
                'users',
                'admins',
                'rearrangedMonths',
                'rearrangedAdoptionRate',
                'months',
                'totalAnimals',
                'admins',
                'regularUsers',
                'adoptionRequest',
                'abuseReport'
            ));
        }
    }



    /**
     * Show a specific animal profile.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $user = Auth::user();
        $notifications = $user->notifications;

        // Fetch the animal profile by ID
        $animal = AnimalProfile::findOrFail($id);

        // Pass the animal profile and notifications to the view
        return view('user.animalProfile', compact('animal', 'notifications'));
    }

    public function profile()
    {
        $user = auth()->user();
        $adoptionRequests = AdoptionRequest::where('user_id', $user->id)->get();
        $abuseReports = AnimalAbuseReport::where('user_id', $user->id)->get();

        return view('user.Profile', compact('user', 'adoptionRequests', 'abuseReports'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $animalProfiles = AnimalProfile::where('name', 'LIKE', "%{$query}%")
            ->orWhere('species', 'LIKE', "%{$query}%")
            ->paginate(15);


        return view('user.home', compact('animalProfiles'));
    }
}
