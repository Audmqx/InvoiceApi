<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\{Invoice, InvoiceLine};
use App\ValueObjects\InvoiceStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;

// Enoncé
// Nous voulons concevoir une API pour accéder à nos factures. 

// Une facture est composée de : 
// Un client* (pour la V1 un simple champ texte)
// Un numéro* 
// Un statut (envoyée, en retard, réglée, annulée)
// Une date d'émission*
// Une note interne (champ texte)
// Une date de règlement
// Une ou plusieurs lignes*

// Une ligne de facture est composée de : 
// Un produit* (pour la V1 un simple champ texte)
// Un montant*

// *: champs obligatoires

// Résultat attendu
// Une route /api/invoices paginée qui rend un json avec 20 factures par page ordonnées par date d’émission
// Chaque facture est représentée par tous ses champs sauf note interne + un champ “total” qui calcule l’ensemble des lignes d’une facture à la volée

// Exemple : 
// {
//       “invoices”: [
//           {
//                “customer” : “John Doe”,
//                “number” : “FA-2022-10-003”,
//                “status” : “sent”,
//                “sent_at” : “2022-10-06 10:02:03”,
//                “paid_at” : null,
//                “total”: 54.20,
//           },
//           {...}
//       ]
// }
// Un seeder qui ajoute 100 factures automatiquement
// Un ou plusieurs tests sur cette route


class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_invoice_and_lines_with_enum_status_and_relationship(): void
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
    public function test_invoice_status_enum(InvoiceStatus $status, string $expectedValue): void
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


