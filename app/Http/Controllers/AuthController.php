<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
	use AuthenticatesAndRegistersUsers, ThrottlesLogins;

	protected $redirectPath = '/admin';

	public function __construct()
	{
		$this->middleware('guest', ['except' => 'getLogout']);
	}

	public function getLogin()
	{
		return view('auth');
	}
}