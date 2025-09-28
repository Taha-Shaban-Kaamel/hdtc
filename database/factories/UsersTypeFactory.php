<?php

namespace Database\Factories;

use App\Models\UsersType;
use Illuminate\Database\Eloquent\Factories\Factory;

class UsersTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UsersType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => [
                'en' => fake()->word,
                'ar' => fake('ar_SA')->word,
            ],
        ];
    }
}
