<?php

namespace App\Models\Invoices;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;
    
    protected $table = 'inv_clients';

    public function getLocationAttribute()
    {
        $location = [
            $this->address,
            $this->city,
            $this->country,
            $this->post_code
        ];

        $location = array_filter($location);
        $location = implode(', ', $location);

        return $location;
    }
}
