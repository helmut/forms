<?php 

$I = new FunctionalTester($scenario);
$I->amOnPage(script(__FILE__));

$I->seeElement('input', ['name'=>'foo']);
$I->seeElement('input', ['name'=>'foo_confirmation']);
$I->see('bar');
