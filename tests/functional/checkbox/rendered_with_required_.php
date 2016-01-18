<?php 

require '../_includes.php';

$form->checkbox('foo')->label('bar')->required();

require '../_view.php';