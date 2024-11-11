<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Admin message view.
     */
    public function adminMessage(Request $request)
    {
        // Ensure only admins can access this method
        $this->authorizeAccess('admin', ['master', 'user']);

        // Store the current view in session
        session(['current_view' => 'admin']);

        return $this->renderMessageView($request, 'admin.Message');
    }

    /**
     * User message view.
     */
    public function userMessage(Request $request)
    {
        // Ensure only users can access this method
        $this->authorizeAccess('user', ['admin', 'master']);

        // Store the current view in session
        session(['current_view' => 'user']);

        return $this->renderMessageView($request, 'user.Message');
    }

    /**
     * Master message view.
     */
    public function masterMessage(Request $request)
    {
        // Ensure only masters can access this method
        $this->authorizeAccess('master', ['admin', 'user']);

        // Store the current view in session
        session(['current_view' => 'master']);

        return $this->renderMessageView($request, 'Master.Message');
    }

    /**
     * Render message view with user chat if provided.
     */
    protected function renderMessageView(Request $request, $view)
    {
        $id = auth()->user()->id;
        $messengerColor = '#8b5e34';  // Default messenger color
        $dark_mode = 'light';      // Default theme mode

        // Check if a chat user is specified in the request
        if ($request->has('chat_user')) {
            $chatUserId = $request->input('chat_user');
            $user = User::find($chatUserId);

            if ($user) {
                return view($view, compact('user', 'id', 'messengerColor', 'dark_mode'));
            }
        }

        return view($view, compact('id', 'messengerColor', 'dark_mode'));
    }

    /**
     * Redirect user to chat with a specific user.
     */
    public function chatWithUser($id)
    {
        // Store the current chat user in session
        session(['chat_user' => $id]);

        // Check user type and redirect accordingly
        $userType = auth()->user()->usertype;

        if ($userType === 'admin') {
            return redirect()->route('admin.Message', ['chat_user' => $id]);
        } elseif ($userType === 'master') {
            return redirect()->route('Master.Message', ['chat_user' => $id]);
        }

        return redirect()->route('user.Message', ['chat_user' => $id]);
    }

    /**
     * Redirect admin to chat with a specific user.
     */
    public function chatWithAdmin($id)
    {
        // Store the current chat user in session
        session(['chat_user' => $id]);

        return redirect()->route('admin.Message', ['chat_user' => $id]);
    }

    /**
     * Redirect master to chat with a specific user.
     */
    public function chatWithMaster($id)
    {
        // Store the current chat user in session
        session(['chat_user' => $id]);

        return redirect()->route('Master.Message', ['chat_user' => $id]);
    }

    /**
     * Check if user has access to their respective views.
     */
    protected function authorizeAccess($role, $restrictedRoles)
    {
        $userType = auth()->user()->usertype;

        // Check if the user is not the required role
        if ($userType !== $role || in_array($userType, $restrictedRoles)) {
            return redirect()->route($this->getRedirectRoute($userType))->with('error', 'Unauthorized access.');
        }

        return true; // Access granted
    }

    /**
     * Get the redirect route based on user type.
     */
    protected function getRedirectRoute($userType)
    {
        switch ($userType) {
            case 'admin':
                return 'admin.Message'; // Redirect to admin messenger
            case 'user':
                return 'user.Message'; // Redirect to user messenger
            case 'master':
                return 'Master.Message'; // Redirect to master messenger
            default:
                return 'user.Message'; // Fallback to user messenger
        }
    }
}
