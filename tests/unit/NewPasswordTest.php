<?php

namespace Helmut\Forms\Testing;

class NewPasswordTest extends FormTestCase {

	/** @test */
	public function it_can_be_rendered()
	{
		$form = $this->form();
		$form->new_password('foo');
        $this->assertContains('<input name="foo" type="password"', $form->render());
        $this->assertContains('<input name="foo_confirmation" type="password"', $form->render());
	}

	/** @test */
	public function it_will_not_render_a_default_value()
	{
		$form = $this->form();
		$form->new_password('foo')->default('bar');
		$this->assertNotContains('value="bar"', $form->render());
	}

	/** @test */
	public function it_will_not_render_a_model_value()
	{
		$form = $this->form();
		$form->defaults($this->model(['foo'=>'bar']));
		$form->new_password('foo');
		$this->assertNotContains('value="bar"', $form->render());
	}

	/** @test */
	public function it_cannot_fill_model_values_using_default()
	{
		$model = $this->model(['foo'=>'']);

		$form = $this->form();
		$form->new_password('foo')->default('bar');
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
            ['foo_confirmation', 'bar'],
    		['baz', true],
    	]));

		$form = $this->form($request);
		$form->new_password('foo');
		$form->button('baz');

		$form->fill($model);

		$this->assertNotEmpty($model->foo);
	}

	/** @test */
	public function it_encrypts_passwords_automatically()
	{
		$model = $this->model(['foo'=>'']);

		$request = $this->request();
    	$request->method('all')->will($this->returnValue(['foo'=>'bar', 'foo_confirmation'=>'bar', 'baz'=>true]));
    	$request->method('get')->will($this->returnValueMap([
            ['foo', 'bar'],
            ['foo_confirmation', 'bar'],
    		['baz', true],
    	]));

		$form = $this->form($request);
		$form->new_password('foo');
		$form->button('baz');

		$form->fill($model);
        
        $this->assertNotEmpty($model->foo);
		$this->assertNotSame($model->foo, 'bar');
	}

	/** @test */
	public function it_provides_expected_values()
	{
		$form = $this->form();
		$form->new_password('foo');

		$this->assertSame($form->get('foo'), '');
	}	

	/** @test */
	public function it_will_not_provide_default_values()
	{
		$form = $this->form();
		$form->new_password('foo')->default('bar');

		$this->assertSame($form->get('foo'), '');
	}

	/** @test */
    public function it_validates_required()
    {
    	$this->assertValid(function($form) { $form->new_password('foo'); });

    	$this->assertNotValid(function($form) { $form->new_password('foo')->required(); });
	}

}
