<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class HealthCheckController extends BaseController
{
	public function index()
	{
		return [
			'message' => 'OK'
		];
	}
}
