<?php

namespace App\Services;

use App\Actions\AccountActions;


class AccountService
{
    protected $accountActions;
    public function __construct(AccountActions $accountActions)
    {
        $this->accountActions = $accountActions;
    }

    public function getAllAccounts()
    {
        return $this->accountActions->getAccounts();
    }
}
