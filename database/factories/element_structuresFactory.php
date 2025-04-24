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
            'id' => $this->faker->randomNumber(),
            'parentId' => $this->faker->slug,
            'type' => $this->faker->slug,
            'order' => $this->faker->slug,
            'dev_name' => $this->faker->slug,
            'value' => $this->faker->word,
            'view_name' => $this->faker->word,
            'CustomStyleOptions' => $this->faker->word,
        ];
    }

}
