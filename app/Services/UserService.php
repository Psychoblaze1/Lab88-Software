<?php

namespace App\Services;

use App\Actions\UserActions;
use Illuminate\Support\Facades\Auth;

class UserService
{
    protected $accountActions, $userActions;
    public function __construct(UserActions $userActions)
    {
        $this->userActions = $userActions;
    }

    public function login($credentials)
    {
        if (!$this->userActions->authenticateLogin($credentials)) {
            return response()->json(
                [
                    'message' => 'Invalid login details, '
                ],
                401
            );
        }

        $this->userActions->createToken(Auth::user());
        return json_decode(json_encode(Auth::user()));
    }
}
