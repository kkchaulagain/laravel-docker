<?php

namespace App\Services\Authorization;

use App\Services\Message\BaseApiService;

class UserSettingService extends BaseApiService
{

    public $url;
    public $service;

    public function __construct()
    {
        $this->service = 'users/settings';
        $this->url = config('services.auth.url');
    }
}
