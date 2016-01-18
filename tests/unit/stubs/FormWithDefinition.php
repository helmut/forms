<?php 

namespace Helmut\Forms\Testing\Stubs;

class FormWithDefinition extends \Helmut\Forms\Form {

	public function define() 
	{
		$this->text('foo');
	}

}
