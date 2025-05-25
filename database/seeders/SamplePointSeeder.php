<?php

namespace Database\Seeders;

use App\Models\SamplePoint;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SamplePointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SamplePoint::factory()->count(10)->create();
    }
}
