<?php

namespace Helmut\Forms\Testing;

class PasswordTest extends FormTestCase {

	/** @test */
	public function it_can_be_rendered()
	{
		$form = $this->form();
		$form->password('foo');
		$this->assertContains('<input name="foo" type="password"', $form->render());
	}

	/** @test */
	public function it_will_not_render_a_default_value()
	{
		$form = $this->form();
		$form->password('foo')->default('bar');
		$this->assertNotContains('value="bar"', $form->render());
	}

	/** @test */
	public function it_will_not_render_a_model_value()
	{
		$form = $this->form();
		$form->defaults($this->model(['foo'=>'bar']));
		$form->password('foo');
		$this->assertNotContains('value="bar"', $form->render());
	}

	/** @test */
	public function it_cannot_fill_model_values_using_default()
	{
		$model = $this->model(['foo'=>'']);

		$form = $this->form();
		$form->password('foo')->default('bar');
		$form->fill($model);

		$form->assertEmpty($model->foo);
	}

	/** @test */
	public function it_can_fill_model_values_using_request()
	{
		$model = $this->model(['foo'=>'']);

		$request = $this->request();
    	$request->method('all')->will($this->returnValue(['foo'=>'bar', 'baz'=>true]));
    	$request->method('get')->will($this->returnValueMap([
    		['foo', 'bar'],
    		['baz', true],
    	]));

		$form = $this->form($request);
		$form->password('foo');
		$form->button('baz');

		$form->fill($model);

		$this->assertNotEmpty($model->foo);
	}

	/** @test */
	public function it_encrypts_passwords_automatically()
	{
		$model = $this->model(['foo'=>'']);

		$request = $this->request();
    	$request->method('all')->will($this->returnValue(['foo'=>'bar', 'baz'=>true]));
    	$request->method('get')->will($this->returnValueMap([
    		['foo', 'bar'],
    		['baz', true],
    	]));

		$form = $this->form($request);
		$form->password('foo');
		$form->button('baz');

		$form->fill($model);

		$this->assertNotSame($model->foo, 'bar');
	}

	/** @test */
	public function it_can_check_if_password_matches()
	{
		$model = $this->model(['foo'=>'']);

		$request = $this->request();
    	$request->method('all')->will($this->returnValue(['foo'=>'bar', 'baz'=>true]));
    	$request->method('get')->will($this->returnValueMap([
    		['foo', 'bar'],
    		['baz', true],
    	]));

		$form = $this->form($request);
		$form->password('foo');
		$form->button('baz');

		$form->fill($model);

		$hash = $form->password('foo')->hash('bar');
		$invalid_hash = $form->password('foo')->hash('invalid');
		$empty_hash = $form->password('foo')->hash('');

		$this->assertTrue($form->password('foo')->matches($hash));
		$this->assertFalse($form->password('foo')->matches($invalid_hash));
		$this->assertFalse($form->password('foo')->matches($empty_hash));
	}

	/** @test */
	public function it_provides_expected_values()
	{
		$form = $this->form();
		$form->password('foo');

		$this->assertSame($form->get('foo'), '');
	}	

	/** @test */
	public function it_will_not_provide_default_values()
	{
		$form = $this->form();
		$form->password('foo')->default('bar');

		$this->assertSame($form->get('foo'), '');
	}

	/** @test */
    public function it_validates_required()
    {
    	$this->assertValid(function($form) { $form->password('foo'); });

    	$this->assertNotValid(function($form) { $form->password('foo')->required(); });
	}

}
