<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdoptionRequest;
use App\Models\AnimalAbuseReport;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    // Show profile page for different user types
    public function Profile()
    {
        // Fetch the authenticated user
        $user = Auth::user();

        // Check if the user is an admin
        if ($user->usertype === 'admin') {


            // Retrieve recent adoption requests (approved and rejected)
            $recentAdoptions = AdoptionRequest::where('approved_by', $user->id)
                ->whereIn('status', ['approved', 'Rejected']) // Fetch only approved or rejected requests
                ->orderBy('updated_at', 'desc') // Order by latest activity
                ->get();

            // Retrieve recent animal abuse reports (approved and rejected)
            $recentAbuseReports = AnimalAbuseReport::where('handled_by', $user->id)
                ->whereIn('status', ['approved', 'Rejected']) // Fetch only approved or rejected reports
                ->orderBy('updated_at', 'desc') // Order by latest activity
                ->get();

            // Return the admin profile view with admin data
            return view('admin.Profile', compact('user', 'recentAdoptions', 'recentAbuseReports'));
        }
        // Check if the user is a master
        elseif ($user->usertype === 'master') {
            // Return the master profile view with master data
            return view('Master.Profile', compact('user'));
        }
        // Check if the user is a regular user
        elseif ($user->usertype === 'user') {
            // Return the user profile view with user data
            return view('user.Profile', compact('user'));
        } else {
            // If user type is unknown, redirect with an error
            return redirect('/')->with('error', 'Unauthorized access.');
        }
    }

    public function edit()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check if the user is an admin
        if ($user->usertype !== 'admin') {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        return view('admin.Settings', compact('user')); // Adjust the view path as needed
    }


    public function update(Request $request)
    {
        $user = Auth::user();
    
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id, // Ensure email is unique, except for the current user's email
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Update the name and email
        $user->name = $request->name;
        $user->email = $request->email;
    
        // Check if a new profile picture is being uploaded
        if ($request->hasFile('profile_picture')) {
            // Delete the old profile picture if it exists
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
    
            // Store the new profile picture
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path; // Save the relative path
        }
    
        // Update phone_number and address only if they are provided
        if ($request->has('phone_number')) {
            $user->phone_number = $request->phone_number;
        }
        if ($request->has('address')) {
            $user->address = $request->address;
        }
    
        // Save the updated user model
        $user->save();
    
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
    
}
