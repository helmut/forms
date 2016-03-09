<?php

namespace Helmut\Forms\Testing;

use Helmut\Forms\Testing\Stubs\Form;

class FormTestCase extends \PHPUnit_Framework_TestCase{
	
	public function request()
	{
		$request = $this->getMock('Helmut\Forms\Request');
    	$request->method('csrf')->will($this->returnValue([]));
		return $request;
	}

	public function form($request=null)
	{
		if ( ! $request) $request = $this->request();

		$form = new Form($request);
		$form->removeAllPlugins();
		return $form;
	}

	public function model($properties = [])
	{
		$model = new \stdClass;
		foreach ($properties as $key => $value) {
			$model->$key = $value;
		}
		return $model;
	}	


	public function assertValid($callback)
	{
		$form = $this->form();
		call_user_func($callback, $form);
		return $this->assertTrue($form->valid());
	}

	public function assertNotValid($callback)
	{
		$form = $this->form();
		call_user_func($callback, $form);
		return $this->assertFalse($form->valid());
	}

	public function tearDown()
    {
        if (class_exists('Mockery')) 
        {
            \Mockery::close();
        }
	}
	
}