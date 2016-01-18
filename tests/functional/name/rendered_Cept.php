<?php 

$I = new FunctionalTester($scenario);
$I->amOnPage(script(__FILE__));

$I->seeElement('input', ['name'=>'foo_first']);
$I->seeElement('input', ['name'=>'foo_surname']);
$I->see('bar');
