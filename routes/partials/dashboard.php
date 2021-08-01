<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::middleware([/*'user_ip',*/ 'auth'])->prefix('dashboard')->group(function() {
	Route::view('/', 'dashboard.index')->name('dashboard.index');

	// Posts
	Route::prefix('posts')->group(function() {
		Route::get('/', [Controllers\Dashboard\Posts\PostController::class, 'index'])->name('dashboard.posts.index');
		
		Route::post('save/{translated_post?}', [Controllers\Dashboard\Posts\PostController::class, 'save'])->name('dashboard.posts.save');
		Route::get('{translated_post}/find', [Controllers\Dashboard\Posts\PostController::class, 'find'])->name('dashboard.posts.find');
		Route::post('{translated_post}/delete/{all?}', [Controllers\Dashboard\Posts\PostController::class, 'delete'])->name('dashboard.posts.delete');
	});

	// Files
	Route::prefix('files')->group(function() {
		Route::get('/', [Controllers\Dashboard\Files\FileController::class, 'index'])->name('dashboard.files.index');
		Route::post('upload', [Controllers\Dashboard\Files\FileController::class, 'store'])->name('dashboard.files.store');
		Route::post('{file_id}/delete', [Controllers\Dashboard\Files\FileController::class, 'delete'])->name('dashboard.files.delete');
	});

	// Invoices
	Route::prefix('invoices')->middleware('can:invoices-management')->group(function() {
		Route::prefix('output')->group(function() {
			Route::get('/journal', [Controllers\Dashboard\Invoices\OutputController::class, 'journal'])->name('dashboard.invoices.journal');
			Route::get('/clients', [Controllers\Dashboard\Invoices\OutputController::class, 'clients'])->name('dashboard.invoices.clients');
		});

		Route::prefix('clients')->group(function() {
			Route::get('/', [Controllers\Dashboard\Invoices\ClientController::class, 'index'])->name('dashboard.invoices.clients.index');
			Route::get('{client}/find', [Controllers\Dashboard\Invoices\ClientController::class, 'find'])->middleware('can:find,client')->name('dashboard.invoices.clients.find');

			Route::post('save/{client?}', [Controllers\Dashboard\Invoices\ClientController::class, 'save'])->name('dashboard.invoices.clients.save');
			
			Route::delete('{client}/delete', [Controllers\Dashboard\Invoices\ClientController::class, 'delete'])->middleware('can:delete,client')->name('dashboard.invoices.clients.delete');
		});

		Route::get('/', [Controllers\Dashboard\Invoices\InvoiceController::class, 'index'])->name('dashboard.invoices.index');
		Route::get('/{invoice}/find', [Controllers\Dashboard\Invoices\InvoiceController::class, 'find'])->middleware('can:find,invoice')->name('dashboard.invoices.find');
	});
});