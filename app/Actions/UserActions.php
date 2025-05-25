<?php

namespace App\Actions;

use App\Models\User;
use App\Traits\StringTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class UserActions
{
    use StringTrait;
    public function getUserByEmail($email)
    {
        return User::with('roles')
            ->where('email', $email)
            ->firstOrFail();
    }

    public function authenticateLogin($credentials)
    {
        return Auth::attempt($credentials);
    }

    public function createToken(User $user)
    {
        return $user->createToken('token-login', ['*'])->plainTextToken;;
    }
}
