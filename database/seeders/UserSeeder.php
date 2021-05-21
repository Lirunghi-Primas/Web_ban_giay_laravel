<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'fullname' => 'Nguyễn Ngọc Thiện',
            'phone_number' => '0355534430',
            'email' => 'lirunghi261@gmail.com',
            'address' => '144/15 Bình Lợi, Bình Thành, tp. Hồ Chí Minh',
            'password' => bcrypt('lirunghi2021')
        ]);
    }
}
