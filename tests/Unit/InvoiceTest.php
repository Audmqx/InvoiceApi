<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Invoice;
use App\ValueObjects\InvoiceStatus;

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

// Bonus 

// Les points suivants ne sont à traiter que s’il vous reste du temps. Nous préférons avoir un travail soigné sur les demandes principales à un travail à revoir mais qui couvre les bonus

// Protéger l’accès à l’API par un mot de passe 1234 passé en paramètre
// Ajouter 2 paramètres “order-by” et “order” (asc ou desc) pour pouvoir trier par nom du client, date d’envoi, montant total.
// Ajouter une méthode POST pour ajouter une facture

class InvoiceTest extends TestCase
{
   
    public function test_invoice_model_and_table_exist(): void
    {
        $seedInvoice = [
			'client' => 'John Doe',
            'number' => 'FA-2022-10-003',
            'status' => 'sent',
            'sent_at' => '2022-10-06 10:02:03',
            'paid_at' => null,
            'internal_note' => "hi",
		];

        $invoice = Invoice::factory()->create($seedInvoice);

        $this->assertModelExists($invoice);
        $this->assertDatabaseHas('invoices', $seedInvoice);
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

    public function test_status_is_casted_to_enum(): void
    {
        $invoice = Invoice::factory()->create([
            'status' => InvoiceStatus::SENT,
        ]);

        $this->assertInstanceOf(InvoiceStatus::class, $invoice->status);
        $this->assertEquals(InvoiceStatus::SENT, $invoice->status);
    }
}

