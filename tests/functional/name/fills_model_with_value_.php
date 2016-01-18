<?php 

require '../_includes.php';

$form->name('foo')->label('bar');
$form->button('go')->label('Go');

if ($form->submitted()) {

	$model = new stdClass;
	$model->foo = '';
	$model->foo_first = '';
	$model->foo_surname = '';

	$form->fill($model);

	exit('Submitted ['.$model->foo.','.$model->foo_first.','.$model->foo_surname.']');

}

require '../_view.php';