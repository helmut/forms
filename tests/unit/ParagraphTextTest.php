<?php

namespace Helmut\Forms\Testing;

class ParagraphTextTest extends FormTestCase {

	/** @test */
	public function it_can_be_rendered()
	{
		$form = $this->form();
		$form->paragraph_text('foo');
		$this->assertContains('<textarea name="foo"', $form->render());
	}

	/** @test */
	public function it_renders_a_default_value()
	{
		$form = $this->form();
		$form->paragraph_text('foo')->default('bar');
		$this->assertContains('<textarea name="foo"', $form->render());
		$this->assertContains('bar</textarea>', $form->render());
	}

	/** @test */
	public function it_renders_model_values()
	{
		$form = $this->form();
		$form->defaults($this->model(['foo'=>'bar']));
		$form->paragraph_text('foo');
		$this->assertContains('<textarea name="foo"', $form->render());
		$this->assertContains('bar</textarea>', $form->render());
	}

	/** @test */
	public function it_can_fill_model_values()
	{
		$model = $this->model(['foo'=>'']);

		$form = $this->form();
		$form->paragraph_text('foo')->default('bar');
		$form->fill($model);

		$form->assertEquals($model->foo, 'bar');
	}

	/** @test */
	public function it_escapes_value()
	{
		$form = $this->form();
		$form->paragraph_text('foo')->default('bar&');
		$this->assertContains('<textarea name="foo"', $form->render());
		$this->assertContains('bar&amp;</textarea>', $form->render());
	}	

	/** @test */
	public function it_provides_expected_values()
	{
		$form = $this->form();
		$form->paragraph_text('foo');

		$this->assertSame($form->get('foo'), '');
	}	

	/** @test */
	public function it_provides_expected_default_values()
	{
		$form = $this->form();
		$form->paragraph_text('foo')->default('bar');

		$this->assertSame($form->get('foo'), 'bar');
	}

	/** @test */
    public function it_validates_required()
    {
    	$this->assertValid(function($form) { $form->paragraph_text('foo'); });

    	$this->assertNotValid(function($form) { $form->paragraph_text('foo')->required(); });
	}

}
