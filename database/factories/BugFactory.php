<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BugFactory extends Factory
{
    public function definition(): array
    {
        return [
            'site_id' => \App\Models\Site::inRandomOrder()->first()->id,
            'logged_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'env' => $this->faker->randomElement(['local', 'staging', 'production']),
            'url' => $this->faker->url,
            'user' => $this->faker->uuid,
            'ip' => $this->faker->ipv4,
            'user_agent' => $this->faker->userAgent,
            'method' => $this->faker->randomElement(['GET', 'POST', 'PUT', 'PATCH', 'DELETE']),
            'path' => $this->faker->filePath.'/'.$this->faker->word,
            'code' => $this->faker->randomElement(['500', '502', '503', '504']),
            'file' => '/var/www/html/'.$this->faker->word.'/'.$this->faker->word.'.php',
            'line' => $this->faker->randomNumber(3),
            'message' => $this->faker->sentence,
        ];
    }
}
