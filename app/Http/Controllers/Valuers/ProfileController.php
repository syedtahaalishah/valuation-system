<?php

namespace App\Http\Controllers\Student;

use App\Traits\FileUpload;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use FileUpload;

    /**
     * Display the student profile page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('screens.student.profile');
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'language' => ['nullable'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'description' => $request->description,
            'language' => $request->language,
            'email' => $request->email,
        ]);

        return response()->json(['successMessage' => 'Profile info updated successfully']);
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

        return response()->json(['successMessage' => 'Profile picture updated successfully']);
    }


}
