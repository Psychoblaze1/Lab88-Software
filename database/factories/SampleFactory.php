<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sample>
 */
class SampleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $account = \App\Models\Account::inRandomOrder()->first();
        $samplePoint = \App\Models\SamplePoint::inRandomOrder()->first();

        return [
            'account_id' => $account->id,
            'sample_point_id' => $samplePoint->id,
            'name' => 'SAMPLE: ' . $this->faker->numerify(' ###'),
            'status' => 1,
            'type' => 'diesel',
            'drawn_by' => 'system',
            'drawn_at' => now(),
        ];
    }
}
