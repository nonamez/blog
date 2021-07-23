<?php

namespace App\Models\Invoices;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
	protected $table = 'inv_invoices';

	protected $dates = ['paid_at'];

	public function client()
	{
		return $this->belongsTo(Client::class);
	}

	public function items()
	{
		return $this->hasMany(Item::class);
	}

	public function getTotalAttribute($value='')
	{
		return $this->items->map(function($item) {
			return $item->sum * $item->count;
		})->sum();
	}
}
