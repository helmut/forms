<?php 

require '../_includes.php';

$form->text('foo')->label('bar')->required();

require '../_view.php';