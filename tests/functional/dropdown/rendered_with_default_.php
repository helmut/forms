<?php 

require '../_includes.php';

$form->dropdown('foo')->label('bar')->options(['a'=>'A', 'b'=>'B', 'c'=>'C'])->default('b');

require '../_view.php';