<?php 

require '../_includes.php';

$form->paragraph_text('foo')->label('bar');
$form->button('go')->label('Go');

require '../_view.php';