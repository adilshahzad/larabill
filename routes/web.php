<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\DashboardController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::resource('customers', CustomerController::class);
Route::resource('invoices', InvoiceController::class);

// PDF Download Route
Route::get('/invoices/{id}/download', [InvoiceController::class, 'downloadPdf'])->name('invoices.download');

// Create a receipt for a specific invoice
Route::get('/invoices/{invoice}/receipts/create', [ReceiptController::class, 'create'])->name('receipts.create');

// Store a receipt for a specific invoice
Route::post('/invoices/{invoice}/receipts', [ReceiptController::class, 'store'])->name('receipts.store');

// Show a specific receipt
Route::get('/receipts/{receipt}', [ReceiptController::class, 'show'])->name('receipts.show');

// Download receipt as PDF
Route::get('/receipts/{receipt}/download', [ReceiptController::class, 'downloadPdf'])->name('receipts.download');

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');