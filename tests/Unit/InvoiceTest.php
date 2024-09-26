<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\{Invoice, InvoiceLine};
use App\ValueObjects\InvoiceStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;


class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_invoice_with_lines_creation(): void
    {
        $invoice = Invoice::factory()->withLines(50)->create();
        $this->assertModelExists($invoice);
 
        $this->assertCount(50, $invoice->invoiceLines); // @phpstan-ignore-line
        $this->assertDatabaseCount('invoice_lines', 50);

        foreach ($invoice->invoiceLines as $line) { // @phpstan-ignore-line
            $this->assertEquals($invoice->id, $line->invoice_id);
            $this->assertModelExists($line);
        }

        $this->assertInstanceOf(InvoiceStatus::class, $invoice->status);
    }

   /**
     * @dataProvider statusProvider
     */
    public function test_invoice_status(InvoiceStatus $status, string $expectedValue): void
    {
        $this->assertEquals($expectedValue, $status->value);
    }

    /**
     * @return array<array{InvoiceStatus, string}>
     */
    static public function statusProvider(): array
    {
        return [
            [InvoiceStatus::SENT, 'sent'],
            [InvoiceStatus::LATE, 'late'],
            [InvoiceStatus::PAID, 'paid'],
            [InvoiceStatus::CANCELLED, 'cancelled'],
        ];
    }
}


