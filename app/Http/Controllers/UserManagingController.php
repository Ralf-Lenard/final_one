<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use App\Models\AdoptionRequest; // Make sure to import your models
use App\Models\AnimalAbuseReport; // Import the model for abuse reports
use Illuminate\Support\Facades\Auth;

class UserManagingController extends Controller
{
    // Make user an admin
    public function makeAdmin($id)
    {
        try {
            $user = User::findOrFail($id); // Find the user by ID

            // Check if the user is already an admin
            if ($user->usertype === 'admin') {
                return redirect()->route('admins.List')->with('info', 'User is already an admin.');
            }

            $user->usertype = 'admin'; // Set user type to admin
            $user->save(); // Save the changes

            return redirect()->route('admins.List')->with('success', 'User is now an admin.');
        } catch (\Exception $e) {
            \Log::error('Error in makeAdmin: ' . $e->getMessage());
            return redirect()->route('admins.List')->with('error', 'An error occurred while updating the user.');
        }
    }

    // Make an admin a regular user
    public function makeUser($id)
    {
        try {
            $user = User::findOrFail($id); // Find the user by ID

            // Check if the user is already a regular user
            if ($user->usertype === 'user') {
                return redirect()->route('users.List')->with('info', 'User is already a regular user.');
            }

            $user->usertype = 'user'; // Set user type to user
            $user->save(); // Save the changes

            return redirect()->route('users.List')->with('success', 'User is now a regular user.');
        } catch (\Exception $e) {
            \Log::error('Error in makeUser: ' . $e->getMessage());
            return redirect()->route('users.List')->with('error', 'An error occurred while updating the user.');
        }
    }

    // Delete any user (including admins) but prevent master admin from deleting themselves
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id); // Find the user by ID

            // Prevent the master admin from deleting themselves
            if ($user->id === auth()->id()) {
                return redirect()->route('master.admin')->with('error', 'You cannot delete yourself.');
            }

            $user->delete(); // Delete the user
            return redirect()->route('master.admin')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Error in destroy: ' . $e->getMessage());
            return redirect()->route('master.admin')->with('error', 'An error occurred while deleting the user.');
        }
    }

    public function user()
    {

        $users = User::where('usertype', 'user')->get(); // Retrieve users with 'user' type
        return view('Master.UserList', compact('users'));
    }
    public function admin()
    {

        $admins = User::where('usertype', 'admin')->get(); // Retrieve users with 'user' type
        return view('Master.AdminList', compact('admins'));
    }


    public function viewUserProfile($id)
    {
        // Fetch the user by ID
        $user = User::findOrFail($id);
    
        // Fetch the latest adoption request for the user's address and phone number
        $adoptionRequest = AdoptionRequest::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first(['address', 'phone_number']); // Specify the fields to retrieve
    
        // Prepare address and phone number, default to empty if no request found
        $address = $adoptionRequest ? $adoptionRequest->address : 'N/A';
        $phoneNumber = $adoptionRequest ? $adoptionRequest->phone_number : 'N/A';
    
        // Fetch recent adoption requests by the user with animal names
        $recentAdoptions = AdoptionRequest::with('animalProfile') // Eager load the animalProfile
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5) // Limit to the 5 most recent
            ->get();
    
        // Fetch recent animal abuse reports by the user
        $recentAbuseReports = AnimalAbuseReport::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5) // Limit to the 5 most recent
            ->get();
    
        // Return the user profile view with user data and recent activities
        return view('Master.UserProfile', [
            'user' => $user,
            'address' => $address,
            'phoneNumber' => $phoneNumber,
            'recentAdoptions' => $recentAdoptions,
            'recentAbuseReports' => $recentAbuseReports,
            'lastLoginAt' => $user->last_login_at,
// Should pass the correct value here

        ]);
    }

    public function viewAdminProfile($id)
    {
        // Retrieve the user by the provided ID
        $admin = User::where('id', $id)->where('usertype', 'admin')->first();
    
        // Check if the admin exists, otherwise throw a 404
        if (!$admin) {
            abort(404, 'Admin not found.');
        }
    
        // Retrieve recent adoption requests (approved and rejected)
        $recentAdoptions = AdoptionRequest::where('approved_by', $admin->id)
            ->whereIn('status', ['approved', 'Rejected']) // Fetch only approved or rejected requests
            ->orderBy('updated_at', 'desc') // Order by latest activity
            ->get();
    
        // Retrieve recent animal abuse reports (approved and rejected)
        $recentAbuseReports = AnimalAbuseReport::where('handled_by', $admin->id)
            ->whereIn('status', ['approved', 'Rejected']) // Fetch only approved or rejected reports
            ->orderBy('updated_at', 'desc') // Order by latest activity
            ->get();
    
        // Return the view and pass the admin and activities data
        return view('Master.AdminProfile', compact('admin', 'recentAdoptions', 'recentAbuseReports'));
    }
    

    
    
    
}
