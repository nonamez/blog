<?php

namespace App\Models\Portfolio;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
	protected $table    = 'prf_codes';
	protected $fillable = ['title'];
}
