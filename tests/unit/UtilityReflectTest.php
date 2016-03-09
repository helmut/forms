<?php

namespace Helmut\Forms\Testing;

use Helmut\Forms\Utility\Reflect;

class UtilityReflectionTest extends FormTestCase {

	/** @test */
	public function it_can_get_filename_from_class()
	{
        $this->assertContains(
            'forms/tests/unit/UtilityReflectTest.php',
            Reflect::getFilename($this)
        );
	}

    /** @test */
    public function it_can_get_directory_from_class()
    {
        $this->assertContains(
            'forms/tests/unit',
            Reflect::getDirectory($this)
        );
    }

    /** @test */
    public function it_can_get_namespace_from_class()
    {
        $this->assertEquals(
            'Helmut\Forms\Testing',
            Reflect::getNamespace($this)
        );
    }

    /** @test */
    public function it_can_get_parameters_from_class()
    {
        $this->assertEquals(
            ['param1', 'param2', 'param3'],
            Reflect::getParameters($this, 'dummyMethodToTestParams')
        );
    }

    public function dummyMethodToTestParams($param1, $param2, $param3) {}    

}