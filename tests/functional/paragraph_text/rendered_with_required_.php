<?php 

require '../_includes.php';

$form->paragraph_text('foo')->label('bar')->required();

require '../_view.php';