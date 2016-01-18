<?php 

require '../_includes.php';

$form->paragraph_text('foo')->label('bar');
$form->button('go')->label('Go');

if ($form->submitted()) {

	$model = new stdClass;
	$model->foo = '';

	$form->fill($model);

	exit('Submitted ['.$model->foo.']');

}

require '../_view.php';