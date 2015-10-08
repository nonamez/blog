<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Lang;
use Response;

abstract class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	protected function ajaxResponse(array $input_data = [], $show_data_on_error = FALSE) {
		$result = array_key_exists('error', $input_data) ? (! (bool) $input_data['error']) : TRUE;
		
		if (array_key_exists('data', $input_data))
			$data = $result ? $input_data['data'] : ($show_data_on_error ? $input_data['data'] : NULL);
		else
			$data = NULL;
		
		if (array_key_exists('message', $input_data))
			$message = $input_data['message'];
		else
			$message = $result ? Lang::get('basics.ajax_response.true') : Lang::get('basics.ajax_response.false');
		
		$err_type = array_key_exists('err_type', $input_data) ? $input_data['err_type'] : FALSE;
		
		$result = [
			'data'     => $data,
			'status'   => $result,
			'message'  => $message,
			'err_type' => $err_type
		];
		
		return Response::json($result);
	}
}
