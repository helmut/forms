<?php 

require '../_includes.php';

$form->name('foo')->label('bar');
$form->button('go')->label('Go');

require '../_view.php';