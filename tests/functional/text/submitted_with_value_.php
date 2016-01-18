<?php 

require '../_includes.php';

$form->text('foo')->label('bar');
$form->button('go')->label('Go');

if ($form->submitted()) {

	exit('Submitted ['.$form->get('foo').']');

}

require '../_view.php';