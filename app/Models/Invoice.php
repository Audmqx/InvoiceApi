<?php

namespace App\Models;

use App\ValueObjects\InvoiceStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Invoice",
 *     description="Invoice model",
 *     @OA\Property(property="id", type="integer", description="The unique identifier for the invoice"),
 *     @OA\Property(property="client", type="string", description="The client associated with the invoice"),
 *     @OA\Property(property="number", type="string", description="The invoice number"),
 *     @OA\Property(property="status", type="string", description="The status of the invoice", enum={"sent", "late", "paid", "cancelled"}),
 *     @OA\Property(property="sent_at", type="string", format="date-time", description="When the invoice was sent"),
 *     @OA\Property(property="paid_at", type="string", format="date-time", nullable=true, description="When the invoice was paid (nullable)"),
 *     @OA\Property(property="total", type="number", format="float", description="The total amount of the invoice calculated from the lines"),
 *     @OA\Property(property="invoice_lines", type="array", description="Lines associated with the invoice", 
 *         @OA\Items(ref="#/components/schemas/InvoiceLine")
 *     )
 * )
 */
class Invoice extends Model
{
    use HasFactory; // @phpstan-ignore-line

    protected $casts = [
        'status' => InvoiceStatus::class,
    ];

    public function invoiceLines() // @phpstan-ignore-line
    {
        return $this->hasMany(InvoiceLine::class);
    }
}
