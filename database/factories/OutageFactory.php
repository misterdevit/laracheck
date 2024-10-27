<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class OutageFactory extends Factory
{
    public function definition(): array
    {
        $solved = rand(0, 1);
        $occurred_at = $this->faker->dateTimeBetween('-1 year', 'now');
        $resolved_at = ($solved) ? $this->faker->dateTimeBetween(
            $occurred_at,
            Carbon::parse($occurred_at)->addHours(4)
        ) : null;

        return [
            'site_id' => \App\Models\Site::inRandomOrder()->first()->id,
            'occurred_at' => $occurred_at,
            'resolved_at' => $resolved_at,
        ];
    }
}
