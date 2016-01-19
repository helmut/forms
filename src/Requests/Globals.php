<?php 

namespace Helmut\Forms\Requests;

use Helmut\Forms\Request;

class Globals implements Request {
	
	public function all()
	{
		return isset($_POST) ? $_POST : [];
	}

	public function get($key)
	{
		return isset($_POST[$key]) ? $_POST[$key] : null;
	}

	public function csrf()
	{
		return [];
	}

}