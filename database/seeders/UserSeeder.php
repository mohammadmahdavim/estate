<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newUsers = [
            0 => [
                'first_name' => 'Masoud',
                'last_name' => 'Seydi',
                'national_code' => '4850172059',
                'password' => bcrypt('123456'),
            ],
        ];
        User::create($newUsers[0]);
    }
}
