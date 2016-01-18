<?php 

require '../_includes.php';

$form->email('foo')->label('bar');
$form->button('go')->label('Go');

require '../_view.php';