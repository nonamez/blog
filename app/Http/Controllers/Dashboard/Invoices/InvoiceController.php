<?php

namespace App\Http\Controllers\Dashboard\Invoices;

use Illuminate\Http\Request;

use App\Models;
use App\Http\Resources;

use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Models\Invoices\Invoice::ofUser()->with('client')->latest('created_at')->get();

        return new Resources\Invoices\InvoiceCollection($invoices);
    }

    public function find(Models\Invoices\Invoice $invoice)
    {
        $invoice->load('client', 'items');

        return new Resources\Invoices\Invoice($invoice);
    }
}
