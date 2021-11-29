<?php

use App\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'vianry',
            'email' => 'vianry.pangemanan@daya-wisesa.com',
            'password' => bcrypt('cobuspotgieter'),
            'remember_token' => Str::random(50),
            'dashboard_id' => 347
        ]);
    }
}
