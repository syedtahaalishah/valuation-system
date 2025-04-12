<?php

namespace App\Http\Controllers\Valuers;

use App\Traits\FileUpload;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    use FileUpload;

    /**
     * Display the valuer profile page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('valuers.profile.index');
    }

    /**
     * Update the student profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'required',
            'reac_number' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif|max:5000',
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'reac_number' => $request->reac_number,

        ]);

        return response()->json(['message' => 'Profile info updated successfully']);
    }

    /**
     * Update the student profile picture.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePicture(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:5000',
        ]);

        $user = Auth::user();

        if ($request->hasFile('image')) {

            $path = public_path('assets/uploads/avatar');

            if ($user->avatar) {
                $this->deleteFile($user->avatar, $path);
            }

            $image = $request->file('image');
            $imageName = $this->uploadFile($image, $path);

            $user->update(['avatar' => $imageName]);
        }

        return response()->json(['message' => 'Profile picture updated successfully']);
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|min:8|different:current_password|confirmed',
        ]);

        $user->update(['password' => Hash::make($validated['new_password'])]);

        return response()->json(['reset' => true, 'message' => 'Password updated successfully']);
    }
}
