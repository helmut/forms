<?php 

require '../_includes.php';

$form->dropdown('foo')->label('bar')->options(['a'=>'A', 'b'=>'B', 'c'=>'C']);
$form->button('go')->label('Go');

if ($form->submitted()) {

	$model = new stdClass;
	$model->foo = '';

	$form->fill($model);

	exit('Submitted ['.$model->foo.']');

}

require '../_view.php';