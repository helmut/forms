<?php 

require '../_includes.php';

$form->checkboxes('foo')->label('bar')->options(['a'=>'A','b'=>'B', 'c'=>'C'])->required();

require '../_view.php';