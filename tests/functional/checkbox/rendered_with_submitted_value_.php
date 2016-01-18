<?php 

require '../_includes.php';

$form->checkbox('foo')->label('bar');
$form->button('go')->label('Go');

require '../_view.php';