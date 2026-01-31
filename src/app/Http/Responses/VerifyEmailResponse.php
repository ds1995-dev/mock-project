<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\VerifyEmailResponse as VerifyEmailResponseContract;

class VerifyEmailResponse implements VerifyEmailResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        if ($user && ! $user->profile_completed) {
            return redirect()->to('/profile/setup');
        }

        return redirect()->to('/');
    }
}
