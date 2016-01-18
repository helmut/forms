<?php 

require '../_includes.php';

$form->dropdown('foo')->label('bar')->options(['a'=>'A', 'b'=>'B', 'c'=>'C'])->required();
$form->button('go')->label('Go');

if ($form->submitted()) {

}

require '../_view.php';