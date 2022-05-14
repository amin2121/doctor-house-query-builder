<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'amin2121',
            'email' => 'aminmutawakkil@gmail.com',
            'password' => Hash::make('amin12345')
        ]);
    }
}
