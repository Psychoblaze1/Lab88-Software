<?php

namespace Database\Seeders;

use App\Models\LimitParameter;
use App\Models\LimitSuite;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LimitSuiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LimitSuite::factory()->count(5)->create();

        $limitSuites = LimitSuite::all();

        foreach ($limitSuites as $suite) {
            for ($i = 0; $i <= 10; $i++) {
                LimitParameter::create(
                    [
                        'limit_suite_id' => $suite->id,
                        'test_parameter_id' => \App\Models\TestParameter::inRandomOrder()->first()->id,
                        'min' => random_int(0, 49),
                        'max' => random_int(50, 100),
                        'comparator' => '><',
                    ]
                );
            }
        }
    }
}
