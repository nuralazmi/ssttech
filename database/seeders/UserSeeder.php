<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = new User();
        $user->name = 'Azmi Nural';
        $user->username = 'nuralazmi';
        $user->password = bcrypt('123456');
        $user->save();
    }
}
