<?php

namespace Helmut\Forms\Testing;

class NameTest extends FormTestCase {

	/** @test */
	public function it_can_be_rendered()
	{
		$form = $this->form();
		$form->name('foo');
		$this->assertContains('<input name="foo_first" value=""', $form->render());
		$this->assertContains('<input name="foo_surname" value=""', $form->render());
	}

	/** @test */
	public function it_renders_default_values()
	{
		$form = $this->form();
		$form->name('foo')->default(['first'=>'bar', 'surname'=>'baz']);
		$this->assertContains('<input name="foo_first" value="bar"', $form->render());
		$this->assertContains('<input name="foo_surname" value="baz"', $form->render());
	}

	/** @test */
	public function it_renders_model_values()
	{
		$form = $this->form();
		$form->defaults($this->model(['foo'=>'bar baz', 'foo_first'=>'bar', 'foo_surname'=>'baz']));
		$form->name('foo');
		$this->assertContains('<input name="foo_first" value="bar"', $form->render());
		$this->assertContains('<input name="foo_surname" value="baz"', $form->render());
	}

	/** @test */
	public function it_can_fill_model_values()
	{
		$model = $this->model(['foo'=>'', 'foo_first'=>'', 'foo_surname'=>'']);

		$form = $this->form();
		$form->name('foo')->default(['first'=>'bar', 'surname'=>'baz']);
		$form->fill($model);

		$form->assertEquals($model->foo, 'bar baz');
		$form->assertEquals($model->foo_first, 'bar');
		$form->assertEquals($model->foo_surname, 'baz');
	}		

	/** @test */
	public function it_escapes_values()
	{
		$form = $this->form();
		$form->name('foo')->default(['first'=>'bar&', 'surname'=>'baz&']);
		$this->assertContains('<input name="foo_first" value="bar&amp;"', $form->render());
		$this->assertContains('<input name="foo_surname" value="baz&amp;"', $form->render());
	}		

	/** @test */
	public function it_provides_expected_values()
	{
		$form = $this->form();
		$form->name('foo');

		$expected = ['foo_first'=>'', 'foo_surname'=>'', 'foo'=>''];
		$this->assertSame($form->get('foo'), $expected);
	}

	/** @test */
	public function it_provides_expected_default_values()
	{
		$form = $this->form();
		$form->name('foo')->default(['first'=>'bar', 'surname'=>'baz']);

		$expected = ['foo_first'=>'bar', 'foo_surname'=>'baz', 'foo'=>'bar baz'];
		$this->assertSame($form->get('foo'), $expected);
	}	

	/** @test */
    public function it_validates_required()
    {
    	$this->assertValid(function($form) { $form->name('foo'); });
    	$this->assertValid(function($form) { $form->name('foo')->default(['first'=>'bar', 'surname'=>'baz'])->required(); });

    	$this->assertNotValid(function($form) { $form->name('foo')->required(); });
    	$this->assertNotValid(function($form) { $form->name('foo')->default(['first'=>'bar'])->required(); });
	}

}
