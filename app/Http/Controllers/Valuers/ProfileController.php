<?php

namespace App\Http\Controllers\Valuers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('screens.valuers.profile.index');
    }

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
