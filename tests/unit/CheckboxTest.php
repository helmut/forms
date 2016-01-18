<?php

namespace Helmut\Forms\Testing;

class CheckboxTest extends FormTestCase {

	/** @test */
	public function it_can_be_rendered()
	{
		$form = $this->form();
		$form->checkbox('foo');
		$this->assertContains('<input name="foo" type="checkbox"', $form->render());
	}

	/** @test */
	public function it_is_unchecked_by_default()
	{
		$form = $this->form();
		$form->checkbox('foo');
		$this->assertNotContains('checked="checked"', $form->render());
	}

	/** @test */
	public function it_can_be_checked()
	{
		$form = $this->form();
		$form->checkbox('foo')->checked();
		$this->assertContains('checked="checked"', $form->render());
	}

	/** @test */
	public function it_renders_model_values()
	{
		$form = $this->form();
		$form->defaults($this->model(['foo'=>1]));
		$form->checkbox('foo');
		$this->assertContains('checked="checked"', $form->render());
	}

	/** @test */
	public function it_can_fill_model_values()
	{
		$model = $this->model(['foo'=>'']);

		$form = $this->form();
		$form->checkbox('foo')->checked();
		$form->fill($model);

		$form->assertEquals($model->foo, 1);
	}		

	/** @test */
	public function it_can_be_unchecked()
	{
		$form = $this->form();
		$form->checkbox('foo')->checked()->unchecked();
		$this->assertNotContains('checked="checked"', $form->render());
	}

	/** @test */
	public function it_provides_expected_values()
	{
		$form = $this->form();
		$form->checkbox('foo');

		$this->assertFalse($form->get('foo'));
	}	

	/** @test */
	public function it_provides_expected_default_values()
	{
		$form = $this->form();
		$form->checkbox('foo')->checked();

		$this->assertTrue($form->get('foo'));
	}	

	/** @test */
    public function it_validates_required()
    {
    	$this->assertValid(function($form) { $form->checkbox('foo'); });
    	$this->assertValid(function($form) { $form->checkbox('foo')->checked()->required(); });

    	$this->assertNotValid(function($form) { $form->checkbox('foo')->required(); });
    	$this->assertNotValid(function($form) { $form->checkbox('foo')->checked()->unchecked()->required(); });
	}

}
