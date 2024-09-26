<?php

namespace App\Http\Controllers;

use App\UseCases\PaginatedInvoices;
use Illuminate\Http\JsonResponse;

class InvoiceController extends Controller
{
    public function __construct(protected PaginatedInvoices $paginatedInvoices) {}

    public function index(): JsonResponse
    {
        return $this->paginatedInvoices->execute()
            ->match(
                fn ($invoices) => response()->json($invoices),
                fn () => response()->json(['error' => 'No invoices found'], 404)
            );
    }
}
