<?php

namespace Database\Seeders;

use App\Models\Sample;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sample::factory()->count(10)->create();

        $samples = Sample::all();
        foreach ($samples as $sample) {
            $sample->statusLogs()->create(
                [
                    'status' => Sample::STATUS_LEVELS[$sample->status],
                    'triggered_by' => 'sample_seeder'
                ]
            );
        }
    }
}
