<?php

return [
	'allowed_ip' => env('ALLOWED_IP') ? explode(',', env('ALLOWED_IP')) : []
];