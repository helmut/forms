<?php 

require '../_includes.php';

$form->number('foo')->label('bar');
$form->button('go')->label('Go');

require '../_view.php';