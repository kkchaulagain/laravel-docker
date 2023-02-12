<?php

namespace App\Http\Controllers;

use App\Services\Account\AccountService;

class AccountController extends BaseController
{

    public $service;

    public function __construct(AccountService $service)
    {
        parent::__construct($service);
    }
}
