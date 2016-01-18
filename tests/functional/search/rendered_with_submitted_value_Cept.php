<?php 

$I = new FunctionalTester($scenario);
$I->amOnPage(script(__FILE__));

$I->fillField('foo', 'qux');
$I->click('Go');

$I->seeElement('input', ['name'=>'foo', 'value'=>'qux']);
