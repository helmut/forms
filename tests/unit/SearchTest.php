<?php

namespace Helmut\Forms\Testing;

class SearchTest extends FormTestCase {

	/** @test */
	public function it_can_be_rendered()
	{
		$form = $this->form();
		$form->search('foo');
		$this->assertContains('<input name="foo" value=""', $form->render());
		$this->assertContains('<button name="foo_button"', $form->render());
	}

	/** @test */
	public function it_renders_a_default_value()
	{
		$form = $this->form();
		$form->search('foo')->default('bar');
		$this->assertContains('<input name="foo" value="bar"', $form->render());
	}

}
