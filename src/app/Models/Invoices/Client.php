<?php

namespace App\Models\Invoices;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models;

class Client extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table    = 'inv_clients';
    protected $fillable = ['name', 'address', 'city', 'country', 'company_code', 'vat_code', 'email', 'phone', 'url'];

    protected $appends  = ['routes'];

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

    public function getRoutesAttribute()
    {
        return (object) [            
            'save'   => route('dashboard.invoices.clients.save', $this->id),
            'find'   => route('dashboard.invoices.clients.find', $this->id),
            'delete' => route('dashboard.invoices.clients.delete', $this->id)
        ];  
    }

    public function scopeOfUser($query)
    {
        $query->where('user_id', auth()->id());

        return $query;
    }

    public function user()
    {
        return $this->belongsTo(Models\Users\User::class);
    }
}
