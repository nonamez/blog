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

    public function save(Models\Users\User $user, Models\Invoices\Client $client = NULL)
    {
        if ($client) {
            return $client->user_id == $user->id;
        }

        return TRUE;
    }

    public function delete(Models\Users\User $user, Models\Invoices\Client $client)
    {
        return $client->user_id == $user->id;
    }
}
