<?php

namespace App\Policies\Invoices;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Models;

class Client
{
    use HandlesAuthorization;

    public function find(Models\Users\User $user, Models\Invoices\Client $client)
    {
        return $client->user_id == $user->id;
    }

    public function update(Models\Users\User $user, Models\Invoices\Client $client)
    {
        return $client->user_id == $user->id;
    }

    public function delete(Models\Users\User $user, Models\Invoices\Client $client)
    {
        return $client->user_id == $user->id;
    }
}
