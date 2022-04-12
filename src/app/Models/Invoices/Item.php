<?php

namespace App\Models\Invoices;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;
    
    protected $table = 'inv_invoice_items';
}
