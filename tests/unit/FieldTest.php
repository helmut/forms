<?php

namespace Helmut\Forms\Testing;

use Helmut\Forms\Testing\Stubs\Field;

class FieldTest extends FormTestCase {

	/** @test */
	public function it_can_be_created()
	{
        $field = new Field($this->form(), 'type', 'name');
        $this->assertEquals(get_class($field), 'Helmut\Forms\Testing\Stubs\Field');
        $this->assertEquals(get_parent_class($field), 'Helmut\Forms\Field');
	}

}