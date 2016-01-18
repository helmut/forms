<?php 

require '../_includes.php';

$form->email('foo')->label('bar')->required();

require '../_view.php';