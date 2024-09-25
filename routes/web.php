<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;

Route::get('api/invoices', [InvoiceController::class, 'index']);