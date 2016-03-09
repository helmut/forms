<?php

namespace Helmut\Forms\Testing;

use Helmut\Forms\Utility\Validate;

class UtilityValidateTest extends FormTestCase {

	/** @test */
	public function it_validates_required()
	{
        $this->assertFalse(Validate::required(null));
        $this->assertFalse(Validate::required(''));
        $this->assertTrue(Validate::required('1'));
        $this->assertTrue(Validate::required(1));
        $this->assertTrue(Validate::required('hello'));
        $this->assertTrue(Validate::required(['1','2','3']));
	}

}