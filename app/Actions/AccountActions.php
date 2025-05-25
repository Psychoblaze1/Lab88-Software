<?php

namespace App\Actions;

use App\Models\Account;

class AccountActions
{

    public function getAccounts()
    {
        return Account::with('users')->get();
    }
}
