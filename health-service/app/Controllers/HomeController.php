<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Presenters\User\UserPresenter;

class HomeController extends BaseController
{
	public function index()
	{
		return [
			'status' => 200,
			'message' => 'Test index',
			'data' => 'index'
		];
	}
}
