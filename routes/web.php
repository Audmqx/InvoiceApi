<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::get('api/invoices', [InvoiceController::class, 'index']);
