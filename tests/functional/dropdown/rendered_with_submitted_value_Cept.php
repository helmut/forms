<?php 

$I = new FunctionalTester($scenario);
$I->amOnPage(script(__FILE__));

$I->selectOption('select[name=foo]', 'B');
$I->click('Go');


$I->seeOptionIsSelected('select[name=foo]', 'B');