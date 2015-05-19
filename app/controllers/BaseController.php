<?php

class BaseController extends Controller {
	
	public function simpleAjaxResponse(array $input_data = NULL, $show_data_on_error = FALSE) {
		$result = isset($input_data['error']) ? (! (bool) $input_data['error']) : TRUE;
		
		if (isset($input_data['data']))
			$data = $result ? $input_data['data'] : ($show_data_on_error ? $input_data['data'] : NULL);
		else
			$data = NULL;
		
		if (isset($input_data['message'])) {
			if (isset($input_data['message']['true'], $input_data['message']['false']))
				$message = $result ? $input_data['message']['true'] : $input_data['message']['false'];
			else
				$message = $input_data['message'];
		} else
			$message = $result ? Lang::get('basics.ajax_response.true') : Lang::get('basics.ajax_response.false');
		
		$err_type = isset($input_data['err_type']) ? $input_data['err_type'] : FALSE;
		
		$result = array(
			'data'     => $data,
			'status'   => $result,
			'message'  => $message,
			'err_type' => $err_type
		);
		
		return Response::json($result);
	}
}
