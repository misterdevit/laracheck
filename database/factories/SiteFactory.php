<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SiteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'url' => $this->faker->url,
            'description' => $this->faker->sentence,
            'email' => $this->faker->email,
            'email_outage' => $this->faker->email,
            'email_resolved' => $this->faker->email,
        ];
    }
}
