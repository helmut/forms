<?php 

require '../_includes.php';

$form->new_password('foo')->label('bar')->required();
$form->button('go')->label('Go');

if ($form->submitted()) {

}

require '../_view.php';