<?php

namespace Database\Factories;

use App\Models\Division;
use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid(), // Generate a UUID for the primary key
            'image' => 'images/' . $this->faker->image('public/storage/images', 640, 480, null, false),
            'name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'division_id' => Division::factory(), // Create a division for this employee
            'position' => $this->faker->jobTitle,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
