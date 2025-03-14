<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition()
    {
        return [
            'client_id' => User::factory(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraphs(3, true),
            'category' => $this->faker->randomElement(['plumbing', 'electricity', 'carpentry']),
            'budget' => $this->faker->numberBetween(500, 10000),
            'budget_type' => $this->faker->randomElement(['fixed', 'hourly', 'estimate']),
            'city' => $this->faker->city,
            'postal_code' => $this->faker->postcode,
            'address' => $this->faker->address,
            'urgent' => $this->faker->boolean(20),
            'verification_method' => $this->faker->randomElement(['phone', 'email']),
            'availability_days' => $this->faker->randomElements(['monday', 'tuesday', 'wednesday', 'thursday', 'friday'], 3),
            'availability_hours' => $this->faker->randomElements(['morning', 'afternoon', 'evening'], 2),
            'status' => 'open'
        ];
    }
}
