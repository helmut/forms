<?php

namespace Helmut\Forms\Testing;

class NumberTest extends FormTestCase {

	/** @test */
	public function it_can_be_rendered()
	{
		$form = $this->form();
		$form->number('foo');
		$this->assertContains('<input name="foo" value=""', $form->render());
	}

	/** @test */
	public function it_renders_a_default_value()
	{
		$form = $this->form();
		$form->number('foo')->default('123');
		$this->assertContains('<input name="foo" value="123"', $form->render());
	}

	/** @test */
	public function it_renders_model_values()
	{
		$form = $this->form();
		$form->defaults($this->model(['foo'=>'bar']));
		$form->number('foo');
		$this->assertContains('<input name="foo" value="bar"', $form->render());
	}

	/** @test */
	public function it_can_fill_model_values()
	{
		$model = $this->model(['foo'=>'']);

		$form = $this->form();
		$form->number('foo')->default('bar');
		$form->fill($model);

		$form->assertEquals($model->foo, 'bar');
	}	

	/** @test */
	public function it_escapes_value()
	{
		$form = $this->form();
		$form->number('foo')->default('123&');
		$this->assertContains('<input name="foo" value="123&amp;"', $form->render());
	}	

	/** @test */
	public function it_provides_expected_values()
	{
		$form = $this->form();
		$form->number('foo');

		$this->assertSame($form->get('foo'), '');
	}	

	/** @test */
	public function it_provides_expected_default_values()
	{
		$form = $this->form();
		$form->number('foo')->default('123');

		$this->assertSame($form->get('foo'), '123');
	}

	/** @test */
    public function it_validates_required()
    {
    	$this->assertValid(function($form) { $form->number('foo'); });

    	$this->assertNotValid(function($form) { $form->number('foo')->required(); });
	}

	/** @test */
    public function it_validates_numeric()
    {
    	$this->assertValid(function($form) { $form->number('foo')->default(123); });

    	$this->assertNotValid(function($form) { $form->number('foo')->default('abc'); });
	}	

	/** @test */
    public function it_validates_between()
    {
    	$this->assertValid(function($form) { $form->number('foo')->between(5, 7); });
    	$this->assertValid(function($form) { $form->number('foo')->between(5, 7)->default('5'); });
    	$this->assertValid(function($form) { $form->number('foo')->between(5, 7)->default('6'); });
    	$this->assertValid(function($form) { $form->number('foo')->between(5, 7)->default('7'); });

    	$this->assertNotValid(function($form) { $form->number('foo')->between(5, 7)->required(); });
    	$this->assertNotValid(function($form) { $form->number('foo')->between(5, 7)->default('3'); });
    	$this->assertNotValid(function($form) { $form->number('foo')->between(5, 7)->default('12'); });
	}

	/** @test */
    public function it_validates_min()
    {
    	$this->assertValid(function($form) { $form->number('foo')->min(5); });
    	$this->assertValid(function($form) { $form->number('foo')->min(5)->default(5); });
    	$this->assertValid(function($form) { $form->number('foo')->min(5)->default(10); });

    	$this->assertNotValid(function($form) { $form->number('foo')->min(5)->required(); });
    	$this->assertNotValid(function($form) { $form->number('foo')->min(5)->default(3); });
    	$this->assertNotValid(function($form) { $form->number('foo')->min(5)->default(-5); });
	}	

	/** @test */
    public function it_validates_max()
    {
    	$this->assertValid(function($form) { $form->number('foo')->max(5); });
    	$this->assertValid(function($form) { $form->number('foo')->max(5)->default(3); });
    	$this->assertValid(function($form) { $form->number('foo')->max(5)->default(5); });

    	$this->assertNotValid(function($form) { $form->number('foo')->max(5)->required(); });
    	$this->assertNotValid(function($form) { $form->number('foo')->max(5)->default(5.1); });
    	$this->assertNotValid(function($form) { $form->number('foo')->max(5)->default(10); });
    	$this->assertNotValid(function($form) { $form->number('foo')->max(5)->default(12345); });
	}

	/** @test */
    public function it_validates_integer()
    {
    	$this->assertValid(function($form) { $form->number('foo')->integer(); });
    	$this->assertValid(function($form) { $form->number('foo')->integer()->default(4); });
    	$this->assertValid(function($form) { $form->number('foo')->integer()->default('4'); });

    	$this->assertNotValid(function($form) { $form->number('foo')->integer()->required(); });
    	$this->assertNotValid(function($form) { $form->number('foo')->integer()->default(10.3); });
    	$this->assertNotValid(function($form) { $form->number('foo')->integer()->default(1/3); });
    	$this->assertNotValid(function($form) { $form->number('foo')->integer()->default('10.2'); });
	}

	/** @test */
    public function it_validates_in()
    {
    	$this->assertValid(function($form) { $form->number('foo')->in(); });
    	$this->assertValid(function($form) { $form->number('foo')->in([1, 2, 3]); });
    	$this->assertValid(function($form) { $form->number('foo')->in([1, 2, 3])->default(1); });

    	$this->assertNotValid(function($form) { $form->number('foo')->in([1, 2, 3])->required(); });
    	$this->assertNotValid(function($form) { $form->number('foo')->in([1, 2, 3])->default(4); });
	}

	/** @test */
    public function it_validates_not_in()
    {
    	$this->assertValid(function($form) { $form->number('foo')->not_in(); });
    	$this->assertValid(function($form) { $form->number('foo')->not_in([1, 2, 3]); });
    	$this->assertValid(function($form) { $form->number('foo')->not_in([1, 2, 3])->default(4); });

    	$this->assertNotValid(function($form) { $form->number('foo')->not_in([1, 2, 3])->required(); });
    	$this->assertNotValid(function($form) { $form->number('foo')->not_in([1, 2, 3])->default(1); });
	}	

}
