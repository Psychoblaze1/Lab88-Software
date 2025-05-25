<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asset>
 */
class AssetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'account_id' => \App\Models\Account::inRandomOrder()->first()->id,
            'site_id' => \App\Models\Site::inRandomOrder()->first()->id,
            'name' => 'ASSET: ' . $this->faker->numerify($this->faker->word() . '###'),
        ];
    }
}
