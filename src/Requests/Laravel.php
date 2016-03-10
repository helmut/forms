<?php 

namespace Helmut\Forms\Requests;

use Helmut\Forms\Request;
use Illuminate\Http\Request as IlluminateRequest;

class Laravel implements Request {
    
    protected $request;

    public function __construct(IlluminateRequest $request)
    {
        $this->request = $request;
    }

    public function all()
    {
        return $this->request->all();
    }

    public function get($key)
    {
        return $this->request->get($key);
    }

    public function csrf()
    {
        return ['name' => '_token', 'value' => csrf_token()];
    }

}