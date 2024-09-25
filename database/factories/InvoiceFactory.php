<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement(['sent', 'late', 'paid', 'cancelled']);
        $sentAt = $status != 'cancelled' ? $this->faker->dateTimeBetween('-30 days', 'now') : null;
        $paidAt = $status == 'paid' ? $this->faker->dateTimeBetween($sentAt, 'now') : null;

        return [
            'client' => $this->faker->name,
            'number' => Str::random(10),
            'status' => $status,
            'sent_at' => $sentAt,
            'paid_at' => $paidAt,
            'internal_note' => $this->faker->sentence,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
