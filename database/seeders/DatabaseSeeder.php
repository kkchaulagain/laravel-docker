<?php

namespace Database\Seeders;

use App\Services\Account\AccountService;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'name'=>'Khutruke Savings',
            'min_balance'=>1000,
            'interest_rate'=>5,
        ];
        (new AccountService())->store($data);
        $data = [
            'name'=>'Normal Savings',
            'min_balance'=>1000,
            'interest_rate'=>5,
        ];
        (new AccountService())->store($data);
    }
}
