<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Invoice;

class InvoiceApiTest extends TestCase
{
    use RefreshDatabase;
    
    // Résultat attendu
    // Une route /api/invoices paginée qui rend un json avec 20 factures par page ordonnées par date d’émission
    // Chaque facture est représentée par tous ses champs sauf note interne + un champ “total” qui calcule l’ensemble des lignes d’une facture à la volée
 
    public function test_paginated_invoices_use_case_success(): void
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

    public function test_returns_404_when_no_invoices_found(): void
    {
        $response = $this->getJson('/api/invoices');

        $response->assertStatus(404);

        $response->assertJson([
            'error' => 'No invoices found',
        ]);
    }
}
