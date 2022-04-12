<?php

namespace App\Policies\Invoices;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Models;

class Invoice
{
    use HandlesAuthorization;

    public function find(Models\Users\User $user, Models\Invoices\Invoice $invoice)
    {
        return $invoice->client->user_id == $user->id;
    }
}
