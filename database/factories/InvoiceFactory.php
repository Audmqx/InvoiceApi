<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\ValueObjects\InvoiceStatus;
use App\Models\{Invoice, InvoiceLine};

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{

    const JUST_A_LINE = 1;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement([
            InvoiceStatus::SENT,
            InvoiceStatus::LATE,
            InvoiceStatus::PAID,
            InvoiceStatus::CANCELLED,
        ]);

        $sentAt = $status != 'cancelled' ? $this->faker->dateTimeBetween('-30 days', 'now') : null;
        $paidAt = $status == 'paid' ? $this->faker->dateTimeBetween($sentAt, 'now') : null;

        

        return [
            'client' => $this->faker->name,
            'number' => Str::random(10),
            'status' => $status->value,
            'sent_at' => $sentAt,
            'paid_at' => $paidAt,
            'internal_note' => $this->faker->sentence,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    public function withLines(int $lineCount = self::JUST_A_LINE): self
    {
        return $this->afterCreating(function (Invoice $invoice) use ($lineCount) {
            InvoiceLine::factory()->count($lineCount)->create([
                'invoice_id' => $invoice->id,
            ]);
        });
    }
}
