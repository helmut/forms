<?php 

$I = new FunctionalTester($scenario);
$I->amOnPage(script(__FILE__));

$I->seeElement('input', ['name'=>'foo_first', 'value'=>'baz']);
$I->seeElement('input', ['name'=>'foo_surname', 'value'=>'qux']);
