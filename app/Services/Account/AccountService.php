<?php

namespace App\Services\Account;

use App\Filters\AccountFilter;
use App\Models\Account;
use App\Services\BaseDatabaseService;

class AccountService extends BaseDatabaseService
{

    public $model = Account::class;
    public $filterObject = AccountFilter::class;
}
