<?php 

require '../_includes.php';

$form->password('foo')->label('bar')->required();
$form->button('go')->label('Go');

if ($form->submitted()) {

}

require '../_view.php';