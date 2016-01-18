<?php 

$I = new FunctionalTester($scenario);
$I->amOnPage(script(__FILE__));

$I->fillField('foo_first', 'baz');
$I->fillField('foo_surname', 'qux');
$I->click('Go');

$I->seeElement('input', ['name'=>'foo_first', 'value'=>'baz']);
$I->seeElement('input', ['name'=>'foo_surname', 'value'=>'qux']);
