<?php

namespace Helmut\Forms\Testing;

use Helmut\Forms\Testing\Stubs\Plugin;

class PluginTest extends FormTestCase {

	/** @test */
	public function it_can_be_instantiated()
	{
        $plugin = new Plugin;
        $this->assertTrue(is_object($plugin));
	}

    /** @test */
    public function it_can_be_instantiated_with_configuration()
    {
        $plugin = new Plugin(['customProperty'=>'testing']);
        $this->assertSame($plugin->getCustomProperty(), 'testing');
    }

}