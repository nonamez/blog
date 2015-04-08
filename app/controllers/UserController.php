<?php 
class UserController extends Controller {
	public function authorize()
	{
		$input = array(
			'email' => Input::get('email'),
			'password' => Input::get('password')
		);
		
		if (Auth::attempt($input))
			return Redirect::intended('/admin');
		
		return Redirect::back()->withInput()->with(array('notice' => Lang::get('errors.incorrect_login')));
	}
}
?>