<?php 

require '../_includes.php';

$form->email('foo')->label('bar')->required();
$form->button('go')->label('Go');

if ($form->submitted()) {

}

require '../_view.php';