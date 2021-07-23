<?php

namespace App\Http\Controllers\Dashboard\Invoices;

use Illuminate\Http\Request;

use App\Models;
use App\Http\Resources;

use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Models\Invoices\Client::get();

        return new Resources\Invoices\Clients\ClientCollection($clients);
    }
}
