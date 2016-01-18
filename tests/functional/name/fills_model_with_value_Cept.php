<?php 

$I = new FunctionalTester($scenario);
$I->amOnPage(script(__FILE__));

$I->fillField('foo_first', 'baz');
$I->fillField('foo_surname', 'qux');
$I->click('Go');
$I->see('Submitted [baz qux,baz,qux]');
