<?php

namespace App\Services\Authorization;

use App\Services\Business\BusinessService;
use App\Services\Mail\GmailService;

class UserService
{
    public $id;
    public $name;
    public $email;
    public $avatar;

    public $roles;
    public $business;
    public $primaryEmail;
    public $associatedEmails;
    public $settings;

    public function __construct($data = [])
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->roles = $data['roles'];
        $this->settings = $data['settings']??[];
        $this->avatar = $data['avatar']??null;
        $this->setBusiness();
        $this->setEmails();
    }

    public function setBusiness()
    {
        $this->business = (new BusinessService())->getMyBusiness($this->id);
        if ($this->business) {
        }
    }

    public function setEmails()
    {
        try {
            $emails = (new GmailService())->getEmailsByUserId($this->id);
            if ($emails['status']) {
                $this->primaryEmail = $emails['data'][0];
                $this->associatedEmails = $emails['data'];
            }
        } catch (\Exception $e) {
            // dd($e);
            // Todo: Error Handling
        }
    }

    public static function loginAsUserId($userId)
    {
        $user = (new AuthorizationService())->select($userId);
        $data = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'roles' => $user['roles'],
        ];
        return new self($data);
    }

    public static function shadowLogin($userId)
    {
        return (new AuthorizationService())->shadowLogin($userId);
    }
   
}
