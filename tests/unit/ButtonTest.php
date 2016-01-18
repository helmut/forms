<?php

namespace Helmut\Forms\Testing;

class ButtonTest extends FormTestCase {

	/** @test */
	public function it_can_be_rendered()
	{
		$form = $this->form();
		$form->button('register');
		$this->assertContains('<button name="register"', $form->render());
	}

	/** @test */
	public function it_does_not_touch_the_model()
	{
		$model = $this->model(['register'=>'123']);

		$form = $this->form();
		$form->button('register');
		$form->fill($model);

		$form->assertEquals($model->register, '123');
	}		

}
