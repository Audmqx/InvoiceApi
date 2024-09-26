<?php

namespace App\Models;

use App\ValueObjects\InvoiceStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
