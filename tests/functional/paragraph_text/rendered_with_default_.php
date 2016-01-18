<?php 

require '../_includes.php';

$form->paragraph_text('foo')->label('bar')->default('baz');

require '../_view.php';