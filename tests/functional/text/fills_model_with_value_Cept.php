<?php 

$I = new FunctionalTester($scenario);
$I->amOnPage(script(__FILE__));

$I->fillField('foo', 'baz');
$I->click('Go');
$I->see('Submitted [baz]');
