<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\UseCases\PaginatedInvoices;

class InvoiceController extends Controller
{
    public function __construct(protected PaginatedInvoices $paginatedInvoices)
    {
    }

    public function index(): JsonResponse
    {
        return $this->paginatedInvoices->execute()
            ->match(
                fn($invoices) => response()->json($invoices),
                fn() => response()->json(['error' => 'No invoices found'], 404) 
            ); 
    }
}
