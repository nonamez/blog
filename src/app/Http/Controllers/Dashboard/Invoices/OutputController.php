<?php

namespace App\Http\Controllers\Dashboard\Invoices;

use Illuminate\Http\Request;

use App\Models;

use App\Http\Controllers\Controller;

class OutputController extends Controller
{
    public function journal()
    {
        $invoices = Models\Invoices\Invoice::with('client', 'items')->orderBy('id', 'desc')->get();

        return view('dashboard.invoices.output.journal', compact('invoices'));
    }

    public function clients()
    {
        $clients = Models\Invoices\Client::get();

        return view('dashboard.invoices.output.clients', compact('clients'));
    }
}
