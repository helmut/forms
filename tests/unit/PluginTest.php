<?php

namespace Helmut\Forms\Testing;

use Helmut\Forms\Testing\Stubs\Plugin;

class PluginTest extends FormTestCase {

	/** @test */
	public function it_can_be_created()
	{
        $plugin = new Plugin;
        $this->assertEquals(get_class($plugin), 'Helmut\Forms\Testing\Stubs\Plugin');
        $this->assertEquals(get_parent_class($plugin), 'Helmut\Forms\Plugin');
	}

    /** @test */
    public function it_can_be_created_with_configuration()
    {
        $plugin = new Plugin(['customProperty'=>'testing']);
        $this->assertSame($plugin->getCustomProperty(), 'testing');
    }

}