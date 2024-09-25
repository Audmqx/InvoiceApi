<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\ValueObjects\InvoiceStatus;

class Invoice extends Model
{
    use HasFactory; // @phpstan-ignore-line

    protected $fillable = [
        'client',
        'number',
        'status',
        'sent_at',
        'paid_at',
        'internal_note',
    ];

    protected $casts = [
        'status' => InvoiceStatus::class,
    ];

    public function invoiceLines() // @phpstan-ignore-line
    {
        return $this->hasMany(InvoiceLine::class);
    }
}
