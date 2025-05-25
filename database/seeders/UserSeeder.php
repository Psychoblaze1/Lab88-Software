<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        User::factory()->count(20)->create();

        User::create(
            [
                'account_id' => \App\Models\Account::inRandomOrder()->first()->id,
                'name' => 'Nick Driffield',
                'email' => 'admin@evolveindustries.co.za',
                'email_verified_at' => now(),
                'password' => bcrypt('0123456789'),
            ]
        );
    }
}
