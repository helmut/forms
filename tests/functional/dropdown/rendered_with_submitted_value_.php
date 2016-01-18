<?php 

require '../_includes.php';

$form->dropdown('foo')->label('bar')->options(['a'=>'A', 'b'=>'B', 'c'=>'C']);
$form->button('go')->label('Go');

require '../_view.php';