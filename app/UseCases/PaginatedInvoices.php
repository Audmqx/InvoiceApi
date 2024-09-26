<?php

namespace App\UseCases;

use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use Innmind\Immutable\Maybe;

final class PaginatedInvoices
{
    const DEFAULT_PAGES = 20;

    public function execute(int $perPage = self::DEFAULT_PAGES): Maybe  // @phpstan-ignore-line
    {
        $invoices = Invoice::with('invoiceLines')  // @phpstan-ignore-line
            ->orderBy('sent_at', 'desc')
            ->paginate($perPage);

        if ($invoices->isEmpty()) {
            return Maybe::nothing();
        }

        return Maybe::just([
            'invoices' => InvoiceResource::collection($invoices),
            'pagination' => [
                'total' => $invoices->total(),
                'current_page' => $invoices->currentPage(),
                'per_page' => $invoices->perPage(),
                'last_page' => $invoices->lastPage(),
            ],
        ]);

    }
}
