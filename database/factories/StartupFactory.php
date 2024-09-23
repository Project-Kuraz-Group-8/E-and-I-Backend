<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Startup>
 */
class StartupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['AI', 'Tech', 'Manufacturing', 'Health', 'Transportation', 'Construction', 'Entertainment'];
        $status = ['open', 'funded', 'closed'];
        return [
           'user_id' => fake()->numberBetween(1,6),
           'title' => fake()->title(), 
           'description' => fake()->paragraph(4), 
           'team_members' => 'Abebe Bikila, Yeshanew Yohannes, Haymanot Aweke, Biruk Dereje, Beamlak Solomon', 
           'goal_amount' => fake()->numberBetween(20, 45) * 1000, 
           'current_amount' => fake()->numberBetween(15, 19) * 1000, 
           'category' => $categories[rand(0,6)], 
           'status' => $status[rand(0,2)]
        ];
    }
}
