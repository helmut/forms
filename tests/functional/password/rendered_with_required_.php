<?php 

require '../_includes.php';

$form->password('foo')->label('bar')->required();

require '../_view.php';