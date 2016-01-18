<?php 

$I = new FunctionalTester($scenario);
$I->amOnPage(script(__FILE__));

$I->selectOption('select[name=foo]', 'A');

$I->click('Go');
$I->see('Submitted [a]');
