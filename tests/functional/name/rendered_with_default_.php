<?php 

require '../_includes.php';

$form->name('foo')->label('bar')->default(['first'=>'baz', 'surname'=>'qux']);

require '../_view.php';