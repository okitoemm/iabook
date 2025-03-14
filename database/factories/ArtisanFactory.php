<?php

namespace Database\Factories;

use App\Models\Artisan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArtisanFactory extends Factory
{
    protected $model = Artisan::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'business_name' => $this->faker->company,
            'siret' => $this->faker->numerify('##############'),
            'specialty' => $this->faker->jobTitle,
            'description' => $this->faker->paragraph(3),
            'experience_years' => $this->faker->numberBetween(1, 30),
            'hourly_rate' => $this->faker->numberBetween(30, 150),
            'service_area' => $this->faker->city,
            'is_verified' => false,
            'rating_average' => 0,
            'total_reviews' => 0,
        ];
    }
}
