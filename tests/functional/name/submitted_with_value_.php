<?php 

require '../_includes.php';

$form->name('foo')->label('bar');
$form->button('go')->label('Go');

if ($form->submitted()) {

	$values = $form->get('foo');

	exit('Submitted ['.$values['foo'].','.$values['foo_first'].','.$values['foo_surname'].']');

}

require '../_view.php';