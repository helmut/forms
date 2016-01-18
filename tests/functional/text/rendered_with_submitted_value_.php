<?php 

require '../_includes.php';

$form->text('foo')->label('bar');
$form->button('go')->label('Go');

require '../_view.php';