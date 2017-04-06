<?php 

require '../_includes.php';

$form->new_password('foo')->label('bar')->required();

require '../_view.php';