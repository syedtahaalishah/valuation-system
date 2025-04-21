<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use App\Models\LoginLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginResponse implements LoginResponseContract
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function toResponse($request)
    {
        $user = auth()->user();

        if (auth()->guard('web')->check()) {
            $user->activities()->create([
                'activity' => auth()->user()->name.' logged in to account',
            ]);
        }

        return $request->wantsJson()
                    ? response()->json(['two_factor' => false])
                    : redirect()->intended(config('fortify.home'));
    }
}
