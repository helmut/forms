<?php

namespace Helmut\Forms\Testing;

class EmailTest extends FormTestCase {

	/** @test */
	public function it_can_be_rendered()
	{
		$form = $this->form();
		$form->email('foo');
		$this->assertContains('<input name="foo" value=""', $form->render());
	}

	/** @test */
	public function it_renders_a_default_value()
	{
		$form = $this->form();
		$form->email('foo')->default('bar');
		$this->assertContains('<input name="foo" value="bar"', $form->render());
	}	

	/** @test */
	public function it_renders_model_values()
	{
		$form = $this->form();
		$form->defaults($this->model(['foo'=>'bar']));
		$form->email('foo');
		$this->assertContains('<input name="foo" value="bar"', $form->render());
	}

	/** @test */
	public function it_can_fill_model_values()
	{
		$model = $this->model(['foo'=>'']);

		$form = $this->form();
		$form->email('foo')->default('bar');
		$form->fill($model);

		$form->assertEquals($model->foo, 'bar');
	}

	/** @test */
	public function it_escapes_value()
	{
		$form = $this->form();
		$form->email('foo')->default('bar&');
		$this->assertContains('<input name="foo" value="bar&amp;"', $form->render());
	}			

	/** @test */
	public function it_provides_expected_values()
	{
		$form = $this->form();
		$form->email('foo');

		$this->assertSame($form->get('foo'), '');
	}	

	/** @test */
	public function it_provides_expected_default_values()
	{
		$form = $this->form();
		$form->email('foo')->default('bar@example.com');

		$this->assertSame($form->get('foo'), 'bar@example.com');
	}

	/** @test */
    public function it_validates_required()
    {
    	$this->assertValid(function($form) { $form->email('foo'); });

    	$this->assertNotValid(function($form) { $form->email('foo')->required(); });
	}

	/** @test */
    public function it_validates_email()
    {
    	$this->assertValid(function($form) { $form->email('foo')->default('bar@example.com'); });
    	$this->assertValid(function($form) { $form->email('foo')->default('bar\'s@example.com'); });

    	$this->assertNotValid(function($form) { $form->email('foo')->default('bar@invalid'); });
    	$this->assertNotValid(function($form) { $form->email('foo')->default('bar@inva\'lid.com'); });
	}

}
