<?php 

namespace Helmut\Forms\Testing;

use Helmut\Forms\Testing\Stubs\FormWithDefinition;
use Helmut\Forms\Testing\Stubs\Custom\FormWithCustomNamespace;
use Helmut\Forms\Testing\Stubs\CustomExtension\FormWithCustomExtension;

class FormTest extends FormTestCase {
	
	/** @test */
    public function it_can_be_created()
    {
    	$this->assertEquals(get_class($this->form()), 'Helmut\Forms\Testing\Stubs\Form');
    	$this->assertEquals(get_parent_class($this->form()), 'Helmut\Forms\Form');
    }

	/** @test */
	public function it_can_be_rendered()
	{
		$form = $this->form();
		
		$this->assertContains('<form', $form->render());
	}	    

	/** @test */
    public function it_can_create_a_field()
    {
    	$form = $this->form();
		$field = $form->text('foo');

    	$this->assertTrue(is_subclass_of($field, 'Helmut\Forms\Field'));
    } 

 	/** @test */
    public function it_can_have_fields_defined()
    {
    	$form = new FormWithDefinition($this->request());
    	$form->removeAllPlugins();

		$fields = $form->fields();
		
		$this->assertCount(1, $form->fields());
    }  

     /** @test */
    public function it_wont_create_the_same_field_twice()
    {
    	$form = $this->form();
		$field1 = $form->text('foo');
		$field2 = $form->text('foo');

		$this->assertCount(1, $form->fields());
		$this->assertSame($field1, $field2);
    }

	/** @test */
    public function it_fetches_all_the_keys()
    {
    	$form = $this->form();
		$form->text('foo');
		$form->name('bar');
		$form->email('baz');

		$expected = ['foo', 'bar_first', 'bar_surname', 'bar', 'baz'];
		$this->assertSame($expected, $form->keys());
	} 

	/** @test */
    public function it_fetches_all_values()
    {
    	$form = $this->form();
		$form->text('foo');
		$form->name('bar');
		$form->email('baz');

		$expected = ['foo'=>'', 'bar_first'=>'', 'bar_surname'=>'', 'bar'=>'', 'baz'=>''];
		$this->assertSame($expected, $form->all());
	}   

	/** @test */
    public function it_fetches_values_for_simple_field()
    {
    	$form = $this->form();
		$form->text('foo');

		$this->assertSame($form->get('foo'), '');
	}	 

	/** @test */
    public function it_fetches_values_for_a_complex_field()
    {
    	$form = $this->form();
		$form->name('foo');

		$expected = ['foo_first'=>'', 'foo_surname'=>'', 'foo'=>''];
		$this->assertSame($form->get('foo'), $expected);
	}

	/** @test */
    public function it_fetches_values_for_a_complex_field_by_key()
    {
    	$form = $this->form();
		$form->name('foo');

		$this->assertSame($form->get('foo', 'surname'), '');
	}

	/** @test */
    public function it_is_not_submitted_by_default()
    {
    	$request = $this->request();
    	$request->method('get')->will($this->returnValueMap([
    			['foo', false],
    		])
    	);

    	$form = $this->form($request);
    	$form->button('foo');

		$this->assertFalse($form->submitted());
	}	

	/** @test */
    public function it_can_be_submitted()
    {
		$request = $this->request();
    	$request->method('get')->will($this->returnValueMap([
    			['foo', true],
    		])
    	);

    	$form = $this->form($request);
    	$form->button('foo');

		$this->assertTrue($form->submitted());
	}

	/** @test */
    public function it_can_detect_which_submit_button_was_clicked()
    {
    	$request = $this->request();
    	$request->method('get')->will($this->returnValueMap([
    			['foo', null],
    			['bar', true],
    		])
    	);

    	$form = $this->form($request);
    	$form->button('foo');
    	$form->button('bar');

		$this->assertFalse($form->submitted('foo'));
		$this->assertTrue($form->submitted('bar'));
	}	

	/** @test */
    public function it_loads_values_from_the_request()
    {
    	$request = $this->request();
    	$request->method('all')->will($this->returnValue(['foo'=>'bar', 'register'=>true]));
    	$request->method('get')->will($this->returnValueMap([
    		['foo', 'bar'],
    		['register', true],
    	]));

		$form = $this->form($request);
		$form->text('foo');
		$form->button('register');

		$this->assertSame($form->get('foo'), 'bar');
	}	

	/** @test */
    public function it_loads_complex_values_from_the_request()
    {
		$request = $this->request();
    	$request->method('all')->will($this->returnValue(['foo_first'=>'John', 'foo_surname'=>'Smith', 'register'=>true]));
    	$request->method('get')->will($this->returnValueMap([
    		['foo_first', 'John'],
    		['foo_surname', 'Smith'],
    		['register', true],
    	]));

		$form = $this->form($request);		
		$form->name('foo');
		$form->button('register');

		$expected = ['foo_first'=>'John', 'foo_surname'=>'Smith', 'foo'=>'John Smith'];
		$this->assertSame($form->get('foo'), $expected);
	}

	/** @test */
    public function it_loads_complex_values_by_key_from_the_request()
    {
		$request = $this->request();
    	$request->method('all')->will($this->returnValue(['foo_first'=>'John', 'foo_surname'=>'Smith', 'register'=>true]));
    	$request->method('get')->will($this->returnValueMap([
    		['foo_first', 'John'],
    		['foo_surname', 'Smith'],
    		['register', true],
    	]));

		$form = $this->form($request);		
		$form->name('foo');
		$form->button('register');

		$this->assertSame($form->get('foo', 'surname'), 'Smith');
	}	

	/** @test */
    public function it_only_loads_values_if_submitted()
    {
		$request = $this->request();
    	$request->method('all')->will($this->returnValue(['foo'=>'bar', 'register'=>null]));
    	$request->method('get')->will($this->returnValueMap([
    		['foo', 'bar'],
    		['register', null],
    	]));

		$form = $this->form($request);		
		$form->text('foo');
		$form->button('register');

		$this->assertSame($form->get('foo'), '');
	}	

	/** @test */
    public function it_is_valid_by_default()
    {
		$form = $this->form();		
		$form->text('foo');
		$form->button('register');

		$this->assertTrue($form->valid());
	}	

	/** @test */
    public function it_can_validate_specific_fields()
    {
		$form = $this->form();		
		$form->email('foo')->default('foo@example.com');
		$form->email('bar')->default('bar@invalid');
		$form->button('register');

		$this->assertTrue($form->valid('foo'));
		$this->assertFalse($form->valid('bar'));
	}

	/** @test */
	public function it_renders_no_errors_unless_submitted()
	{
		$form = $this->form();
		$form->text('foo')->required();
		$form->button('register');
		
		$this->assertNotContains('<p class="error_message"', $form->render());
	}

	/** @test */
	public function it_renders_errors()
	{
		$request = $this->request();
    	$request->method('get')->will($this->returnValueMap([
    		['foo', ''],
    		['register', true],
    	]));

		$form = $this->form($request);
		$form->text('foo')->required();
		$form->button('register');

		$this->assertContains('<p class="error_message">', $form->render());
	}

	/** @test */
	public function it_renders_default_language()
	{
		$form = $this->form();
		$form->text('foo')->required();
		$form->button('register');

		$this->assertContains('This field is required.', $form->render());
	}

	/** @test */
	public function it_renders_default_added_language()
	{
		$form = $this->form();
		$form->setLanguage('es');
		$form->text('foo')->required();

		$this->assertContains('Este campo es obligatorio.', $form->render());
	}	

	/** @test */
	public function it_sets_own_namespace()
	{	
		$form = $this->form();

		$this->assertSame($form->namespaces(), ['Helmut\Forms\Testing\Stubs', 'Helmut\Forms']);
	}

	/** @test */
	public function it_can_add_a_namespace()
	{
		$form = $this->form();
		$form->addNamespace('My\Custom\Namespace');
		$form->addNamespace('My\Other\Custom\Namespace');

		$this->assertSame($form->namespaces(), ['My\Other\Custom\Namespace', 'My\Custom\Namespace', 'Helmut\Forms\Testing\Stubs', 'Helmut\Forms']);
	}

	/** @test */
	public function it_can_add_autoload_paths()
	{
		$form = $this->form();
		$form->addPath(__DIR__.'/folder');
		$form->addPath(__DIR__.'/folder/subfolder');

		$paths = $form->paths();

		$this->assertCount(4, $paths);
		$this->assertContains('forms/tests/unit/folder/subfolder', $paths[0]);
		$this->assertContains('forms/tests/unit/folder/', $paths[1]);
		$this->assertContains('forms/tests/unit/stubs/', $paths[2]);
		$this->assertContains('forms/src/', $paths[3]);
	}

	/** @test */
	public function it_will_not_add_autoload_paths_that_do_not_exist()
	{
		$form = $this->form();
		$form->addPath(__DIR__.'/folder');
		$form->addPath(__DIR__.'/folder/subfolder');
		$form->addPath(__DIR__.'/folder/doesnotexist');

		$paths = $form->paths();

		$this->assertCount(4, $paths);
		$this->assertContains('forms/tests/unit/folder/subfolder', $paths[0]);
		$this->assertContains('forms/tests/unit/folder/', $paths[1]);
		$this->assertContains('forms/tests/unit/stubs/', $paths[2]);
		$this->assertContains('forms/src/', $paths[3]);
	}	

	/** @test */
	public function it_adds_autoload_paths_with_trailing_slash()
	{
		$form = $this->form();
		$form->addPath(__DIR__.'/folder/');
		$form->addPath(__DIR__.'/folder/subfolder/');

		$paths = $form->paths();

		$this->assertContains('forms/tests/unit/folder/subfolder', $paths[0]);
		$this->assertContains('forms/tests/unit/folder/', $paths[1]);
		$this->assertContains('forms/tests/unit/stubs/', $paths[2]);
		$this->assertContains('forms/src/', $paths[3]);
	}

	/** @test */
	public function it_can_set_template()
	{
		$form = $this->form();
		$form->setTemplate('testing');

		$paths = $form->templatePaths();

		$this->assertCount(1, $paths);
		$this->assertContains('forms/tests/unit/stubs/templates/testing/', $paths[0]);
	}

	/** @test */
	public function it_will_not_add_template_path_that_does_not_exist()
	{
		$form = $this->form();
		$form->setTemplate('doesnotexist');

		$paths = $form->templatePaths();

		$this->assertCount(0, $paths);
	}	

	/** @test */
	public function it_sets_template_autoload_path()
	{
		$form = $this->form();
		
		$paths = $form->templatePaths();

		$this->assertCount(2, $paths);
		$this->assertContains('forms/tests/unit/stubs/templates/bootstrap/', $paths[0]);
		$this->assertContains('forms/src/templates/bootstrap/', $paths[1]);
	}

	/** @test */
	public function it_uses_added_autoload_paths_to_find_templates()
	{
		$form = $this->form();
		$form->addPath(__DIR__.'/folder');

		$paths = $form->templatePaths();

		$this->assertCount(3, $paths);
		$this->assertContains('forms/tests/unit/folder/templates/bootstrap/', $paths[0]);
		$this->assertContains('forms/tests/unit/stubs/templates/bootstrap/', $paths[1]);
		$this->assertContains('forms/src/templates/bootstrap/', $paths[2]);
	}

	/** @test */
	public function it_uses_added_autoload_paths_to_find_templates_with_a_set_template()
	{
		$form = $this->form();
		$form->setTemplate('testing');
		$form->addPath(__DIR__.'/folder');

		$paths = $form->templatePaths();

		$this->assertCount(2, $paths);
		$this->assertContains('forms/tests/unit/folder/templates/testing/', $paths[0]);
		$this->assertContains('forms/tests/unit/stubs/templates/testing/', $paths[1]);
	}	

	/** @test */
	public function it_sets_your_namespace_as_an_autoload_path()
	{
    	$form = new FormWithCustomNamespace($this->request());
		$form->removeAllPlugins();

		$paths = $form->paths();

		$this->assertCount(2, $paths);
		$this->assertContains('tests/unit/stubs/Custom/', $paths[0]);
		$this->assertContains('forms/src/', $paths[1]);
	}

	/** @test */
	public function it_sets_your_namespace_and_parent_namespaces_as_an_autoload_path()
	{
    	$form = new FormWithCustomExtension($this->request());
		$form->removeAllPlugins();

		$paths = $form->paths();

		$this->assertCount(3, $paths);
		$this->assertContains('tests/unit/stubs/CustomExtension/', $paths[0]);
		$this->assertContains('tests/unit/stubs/CustomExtension/FormExtension/', $paths[1]);
		$this->assertContains('forms/src/', $paths[2]);
	}

	/** @test */
	public function it_sets_your_namespace_template_autoload_path_with_added_template()
	{
    	$form = new FormWithCustomNamespace($this->request());
		$form->removeAllPlugins();    	
		$form->setTemplate('testing');

		$paths = $form->templatePaths();

		$this->assertCount(1, $paths);
		$this->assertContains('tests/unit/stubs/Custom/templates/testing/', $paths[0]);
	}		

	/** @test */
	public function it_renders_using_your_namespace_template()
	{
    	$form = new FormWithCustomNamespace($this->request());
		$form->removeAllPlugins();

		$this->assertContains('it_renders_using_your_namespace_template', $form->render());
	}

}