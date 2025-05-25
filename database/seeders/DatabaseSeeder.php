<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
        // setup system
        $this->call(LibrarySeeder::class);

        // for dev
        $this->call(AccountSeeder::class);
        $this->call(UserSeeder::class);
        // $this->call(SiteSeeder::class);
        // $this->call(AssetSeeder::class);
        // $this->call(ComponentSeeder::class);
        // $this->call(SamplePointSeeder::class);
        $this->call(AssetChainSeeder::class);
        $this->call(LimitSuiteSeeder::class);
        // $this->call(SampleSeeder::class);
        // $this->call(LabSeeder::class);
    }
}
