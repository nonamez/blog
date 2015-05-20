<?php 
class AuthController extends Controller {
	
	public function index()
	{
		return View::make('auth');
	}
	
	public function authorize()
	{
		$allowed_ip = Config::get('blog.allowed_ip');
		
		if (is_array($allowed_ip) && in_array(Request::getClientIp(TRUE), $allowed_ip) == FALSE)
			return Redirect::back()->withErrors(Lang::get('errors.incorrect_login_ip'));
		
		$input = array(
			'email' => Input::get('email'),
			'password' => Input::get('password')
		);
		
		if (Auth::attempt($input))
			return Redirect::intended('/admin');
		
		return Redirect::back()->withInput()->with(array('notice' => Lang::get('errors.incorrect_login')));
	}
	
	public function logOut()
	{
		Auth::logout();
		
		return Redirect::to('/');
	}
}
?>