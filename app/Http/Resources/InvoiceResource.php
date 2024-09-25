<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
             'client' => $this->client, // @phpstan-ignore-line
             'number' => $this->number, // @phpstan-ignore-line
             'status' => $this->status->value, // @phpstan-ignore-line
             'sent_at' => $this->sent_at, // @phpstan-ignore-line
             'paid_at' => $this->paid_at, // @phpstan-ignore-line 
             'total' => $this->invoiceLines->sum('amount') // @phpstan-ignore-line
         ];
    }
}
