<?php

namespace Helmut\Forms\Testing;

use Helmut\Forms\Utility\Str;

class UtilityStrTest extends FormTestCase {

	/** @test */
	public function it_converts_to_snake_case()
	{
        $this->assertEquals('test', Str::snake('test'));
        $this->assertEquals('test', Str::snake('Test'));
        $this->assertEquals('test_word', Str::snake('TestWord'));
        $this->assertEquals('test_multiple_words', Str::snake('TestMultipleWords'));
	}

    /** @test */
    public function it_converts_to_studly_caps()
    {
        $this->assertEquals('Test', Str::studly('test'));
        $this->assertEquals('Test', Str::studly('Test'));
        $this->assertEquals('TestWord', Str::studly('test_word'));
        $this->assertEquals('TestMultipleWords', Str::studly('test_multiple_words'));
    }

}