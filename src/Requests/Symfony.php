<?php 

namespace Helmut\Forms\Requests;

use Helmut\Forms\Request;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class Symfony implements Request {
	
	protected $request;

	public function __construct()
	{
		$this->request = SymfonyRequest::createFromGlobals();
	}

	public function all()
	{
		return $this->request->request->all();
	}

	public function get($key)
	{
		return $this->request->request->get($key);
	}

	public function csrf()
	{
		return ['name' => '_token', 'value' => csrf_token()];
	}

}