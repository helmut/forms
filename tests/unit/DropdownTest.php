<?php

namespace Helmut\Forms\Testing;

class DropdownTest extends FormTestCase {

	/** @test */
	public function it_can_be_rendered()
	{
		$form = $this->form();
		$form->dropdown('foo')->options(['a'=>'A', 'b'=>'B', 'c'=>'C']);
		$this->assertContains('<select name="foo"', $form->render());
		$this->assertContains('<option value="a">A</option>', $form->render());
		$this->assertContains('<option value="b">B</option>', $form->render());
		$this->assertContains('<option value="c">C</option>', $form->render());
	}

	/** @test */
	public function it_renders_a_default_value()
	{
		$form = $this->form();
		$form->dropdown('foo')->options(['a'=>'A', 'b'=>'B', 'c'=>'C'])->default('b');

		$this->assertContains('<option value="a">A</option>', $form->render());
		$this->assertContains('<option value="b" selected="selected">B</option>', $form->render());
		$this->assertContains('<option value="c">C</option>', $form->render());
	}

	/** @test */
	public function it_renders_model_values()
	{
		$form = $this->form();
		$form->defaults($this->model(['foo'=>'b']));
		$form->dropdown('foo')->options(['a'=>'A', 'b'=>'B', 'c'=>'C']);

		$this->assertContains('<option value="a">A</option>', $form->render());
		$this->assertContains('<option value="b" selected="selected">B</option>', $form->render());
		$this->assertContains('<option value="c">C</option>', $form->render());
	}

	/** @test */
	public function it_can_fill_model_values()
	{
		$model = $this->model(['foo'=>'']);

		$form = $this->form();
		$form->dropdown('foo')->options(['a'=>'A', 'b'=>'B', 'c'=>'C'])->default('b');
		$form->fill($model);

		$form->assertEquals($model->foo, 'b');
	}	

	/** @test */
	public function it_provides_expected_values()
	{
		$form = $this->form();
		$form->dropdown('foo')->options(['a'=>'A', 'b'=>'B', 'c'=>'C']);

		$this->assertSame($form->get('foo'), '');
	}	

	/** @test */
	public function it_provides_expected_default_values()
	{
		$form = $this->form();
		$form->dropdown('foo')->options(['a'=>'A', 'b'=>'B', 'c'=>'C'])->default('c');

		$this->assertSame($form->get('foo'), 'c');
	}

	/** @test */
    public function it_validates_required()
    {
    	$this->assertValid(function($form) { $form->dropdown('foo')->options(['a'=>'A', 'b'=>'B', 'c'=>'C']); });

    	$this->assertNotValid(function($form) { $form->dropdown('foo')->options(['a'=>'A', 'b'=>'B', 'c'=>'C'])->required(); });
	}	

}
