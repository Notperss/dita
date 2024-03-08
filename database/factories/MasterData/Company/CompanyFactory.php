<?php

namespace Database\Factories\MasterData\Company;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MasterData\Company\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() : array
    {
        return [
            'name' => $this->faker->company(),
            'address' => $this->faker->address(),
            'description' => $this->faker->unique()->companyEmail(),
        ];
    }
}
