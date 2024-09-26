<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="InvoiceLine",
 *     description="Invoice line model",
 *
 *     @OA\Property(property="id", type="integer", description="The unique identifier for the invoice line"),
 *     @OA\Property(property="product", type="string", description="The product or service sold"),
 *     @OA\Property(property="amount", type="number", format="float", description="The amount for the product/service"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="When the invoice line was created"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="When the invoice line was last updated")
 * )
 */
class InvoiceLine extends Model
{
    use HasFactory; // @phpstan-ignore-line

    public function invoice() // @phpstan-ignore-line
    {
        return $this->belongsTo(Invoice::class);
    }
}
