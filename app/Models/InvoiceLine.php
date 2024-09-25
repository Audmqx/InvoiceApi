<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceLine extends Model
{
    use HasFactory; // @phpstan-ignore-line

    public function invoice() // @phpstan-ignore-line
    {
        return $this->belongsTo(Invoice::class);
    }
}
