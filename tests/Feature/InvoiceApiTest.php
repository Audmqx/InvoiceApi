<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Invoice;

class InvoiceApiTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_invoices_pagination_useCase(): void
    {
            Invoice::factory()->withLines(3)->count(25)->create();

            $response = $this->getJson('/api/invoices');

            $response->assertStatus(200);

            $response->assertJsonStructure([
                'invoices' => [
                    '*' => [
                        'client',
                        'number',
                        'status',
                        'sent_at',
                        'paid_at',
                        'total'
                    ],
                ],
                'pagination' => [
                    'total',
                    'current_page',
                    'per_page',
                    'last_page',
                ],
            ]);
    }

    public function test_when_no_invoices_found(): void
    {
        $response = $this->getJson('/api/invoices');

        $response->assertStatus(404);

        $response->assertJson([
            'error' => 'No invoices found',
        ]);
    }
}
