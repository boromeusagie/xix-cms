<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Admin';
        $user->username = 'admin';
        $user->email = 'test@admin.com';
        $user->password = Hash::make('xix1234');
        $user->email_verified_at = Carbon::now();
        $user->role = 0;
        $user->save();
    }
}
