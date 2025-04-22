<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\element_structures>
 */
class element_structuresFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'dev_name' => $this->faker->slug,
            'default_value' => $this->faker->word,
            'value' => $this->faker->word,
            'view_name' => $this->faker->word,
        ];
    }

}
