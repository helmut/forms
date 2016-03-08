<?php

namespace Helmut\Forms\Testing;

use Helmut\Forms\Testing\Stubs\Field;

class FieldTest extends FormTestCase {

	/** @test */
	public function it_can_be_instantiated()
	{
        $field = new Field($this->form(), 'type', 'name');
        $this->assertTrue(is_object($field));
	}

}