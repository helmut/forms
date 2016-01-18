<?php

namespace Helmut\Forms\Testing;

class CheckboxesTest extends FormTestCase {

	/** @test */
	public function it_can_be_rendered()
	{
		$form = $this->form();
		$form->checkboxes('foo')->options(['a'=>'A', 'b'=>'B', 'c'=>'C']);
		$this->assertContains('<input name="foo_a" type="checkbox"', $form->render());
		$this->assertContains('<input name="foo_b" type="checkbox"', $form->render());
		$this->assertContains('<input name="foo_c" type="checkbox"', $form->render());
	}

	/** @test */
	public function it_is_unchecked_by_default()
	{
		$form = $this->form();
		$form->checkboxes('foo')->options(['a'=>'A', 'b'=>'B', 'c'=>'C']);
		$this->assertNotContains('checked="checked"', $form->render());
	}	

	/** @test */
	public function it_can_be_checked()
	{
		$form = $this->form();
		$form->checkboxes('foo')->options(['a'=>'A', 'b'=>'B', 'c'=>'C'])->checked();

		$this->assertContains('<input name="foo_a" type="checkbox" checked="checked"', $form->render());
		$this->assertContains('<input name="foo_b" type="checkbox" checked="checked"', $form->render());
		$this->assertContains('<input name="foo_c" type="checkbox" checked="checked"', $form->render());
	}

	/** @test */
	public function it_can_be_unchecked()
	{
		$form = $this->form();
		$form->checkboxes('foo')->options(['a'=>'A', 'b'=>'B', 'c'=>'C'])->checked()->unchecked();

		$this->assertNotContains('checked="checked"', $form->render());
	}

	/** @test */
	public function it_can_check_specific_options()
	{
		$form = $this->form();
		$form->checkboxes('foo')->options(['a'=>'A', 'b'=>'B', 'c'=>'C'])->checked(['a', 'c']);

		$this->assertContains('<input name="foo_a" type="checkbox" checked="checked"', $form->render());
		$this->assertNotContains('<input name="foo_b" type="checkbox" checked="checked"', $form->render());
		$this->assertContains('<input name="foo_c" type="checkbox" checked="checked"', $form->render());
	}

	/** @test */
	public function it_can_uncheck_specific_options()
	{
		$form = $this->form();
		$form->checkboxes('foo')->options(['a'=>'A', 'b'=>'B', 'c'=>'C'])->checked()->unchecked(['a', 'c']);

		$this->assertNotContains('<input name="foo_a" type="checkbox" checked="checked"', $form->render());
		$this->assertContains('<input name="foo_b" type="checkbox" checked="checked"', $form->render());
		$this->assertNotContains('<input name="foo_c" type="checkbox" checked="checked"', $form->render());
	}	

	/** @test */
	public function it_renders_model_values()
	{
		$form = $this->form();
		$form->defaults($this->model(['foo_a'=>0, 'foo_b'=>1, 'foo_c'=>0]));
		$form->checkboxes('foo')->options(['a'=>'A', 'b'=>'B', 'c'=>'C']);

		$this->assertNotContains('<input name="foo_a" type="checkbox" checked="checked"', $form->render());
		$this->assertContains('<input name="foo_b" type="checkbox" checked="checked"', $form->render());
		$this->assertNotContains('<input name="foo_c" type="checkbox" checked="checked"', $form->render());
	}

	/** @test */
	public function it_can_fill_model_values()
	{
		$model = $this->model(['foo_a'=>0, 'foo_b'=>0, 'foo_c'=>0]);

		$form = $this->form();
		$form->checkboxes('foo')->options(['a'=>'A', 'b'=>'B', 'c'=>'C'])->checked(['a', 'c']);
		$form->fill($model);

		$form->assertEquals($model->foo_a, 1);
		$form->assertEquals($model->foo_b, 0);
		$form->assertEquals($model->foo_c, 1);
	}	

	/** @test */
	public function it_provides_expected_values()
	{
		$form = $this->form();
		$form->checkboxes('foo')->options(['a'=>'A', 'b'=>'B', 'c'=>'C']);

		$expected = ['foo_a'=>false, 'foo_b'=>false, 'foo_c'=>false];
		$this->assertSame($form->get('foo'), $expected);
	}		

	/** @test */
	public function it_provides_expected_default_values()
	{
		$form = $this->form();
		$form->checkboxes('foo')->options(['a'=>'A', 'b'=>'B', 'c'=>'C'])->checked(['a', 'c']);

		$expected = ['foo_a'=>true, 'foo_b'=>false, 'foo_c'=>true];
		$this->assertSame($form->get('foo'), $expected);
	}

	/** @test */
    public function it_validates_required()
    {
   		$this->assertValid(function($form) { $form->checkboxes('foo')->options(['a'=>'A', 'b'=>'B', 'c'=>'C']); });
    	$this->assertValid(function($form) { $form->checkboxes('foo')->options(['a'=>'A', 'b'=>'B', 'c'=>'C'])->checked()->required(); });

    	$this->assertNotValid(function($form) { $form->checkboxes('foo')->options(['a'=>'A', 'b'=>'B', 'c'=>'C'])->required(); });
    	$this->assertNotValid(function($form) { $form->checkboxes('foo')->options(['a'=>'A', 'b'=>'B', 'c'=>'C'])->checked()->unchecked()->required(); });
	}		

}
