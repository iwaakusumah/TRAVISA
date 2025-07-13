<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'class' => $this->faker->randomElement(['10', '11']),
            'major' => $this->faker->randomElement(['TKJ', 'AK', 'AP', 'TKR']),
            'academic_year' => $this->faker->randomElement(['2023/2024']),
            'user_id' => null, // akan ditentukan di seeder
        ];
    }
}
