<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function UserProfile(){
        $id=Auth::user()->id;
        $profileData=User::find($id);
        return view('admin.admin_profile_view', compact('profileData'));


    }
   public function UserProfileStore(Request $request)
{
    // Define your validation rules
    $rules = [
        'email' => 'required|email|unique:users,email,' . Auth::user()->id, // Unique email, excluding the current user's email
        'username' => 'required|string|max:255',
        'password' => 'nullable|string|min:8', // Password is optional but must be min 8 characters if provided
        'photo' => 'nullable|image',        // Photo is optional but must be an image if provided
    ];

    // Run validation
    $request->validate($rules);

    // Update user data
    $id = Auth::user()->id;
    $profileData = User::find($id);
    $profileData->email = $request->email;
    $profileData->name = $request->username;

    // Update password if provided
    if (!empty($request->password)) {
        $profileData->password = Hash::make($request->password);
    }

    // Handle file upload
    if ($request->file('photo')) {
        $file = $request->file('photo');
       unlink(public_path('upload/admin_images/' . $profileData->photo));//q:explain this line 
        
        $filename = date('YmdHi') . $file->getClientOriginalName();

        $file->move(public_path('upload/admin_images'), $filename);
        $profileData['photo'] = $filename;
    }

    $profileData->save();
    $notification = array(
        'message' => 'Profile updated successfully',
        'alert-type' => 'success'
    );
    return redirect()->back()->with($notification);
}
}
