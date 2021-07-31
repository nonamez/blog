<?php

namespace App\Http\Controllers\Dashboard\Invoices;

use Illuminate\Http\Request;

use App\Models;
use App\Policies;
use App\Http\Resources;

use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Models\Invoices\Client::ofUser()->get();

        return new Resources\Invoices\Clients\ClientCollection($clients);
    }

    public function find(Models\Invoices\Client $client)
    {
        return new Resources\Invoices\Clients\Client($client);
    }

    public function save(Request $request, Models\Invoices\Client $client = NULL)
    {
        $rules = [
            'name' => ['required', 'string', 'min:5'],

            'address' => ['required', 'min:'],
            'city'    => ['required', 'min:'],
            'country' => ['required', 'min:'],

            'company_code' => ['present'],
            'vat_code'     => ['present'],

            'email' => ['required_without:phone', 'nullable', 'email'],
            'phone' => ['required_without:email', 'nullable', 'regex:\+\d+'],

            'url' => 'url'
        ];

        $request->validate($rules);

        if ($client == NULL) {
            $client = new Models\Invoices\Client;

            $client->user_id = auth()->id();
        }

        $client->fill($request->only('name', 'address', 'city', 'country', 'company_code', 'vat_code', 'email', 'phone', 'url'));

        $client->save();

        return $this->find($client);
    }

    public function delete(Models\Invoices\Client $client)
    {   
        $name = $client->name;

        $client->delete();        
        
        return new \Illuminate\Http\Resources\Json\JsonResource(['message' => sprintf('The post "%s" successfully deleted', $name)]);
    }
}
