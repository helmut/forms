<?php 

$I = new FunctionalTester($scenario);
$I->amOnPage(script(__FILE__));

$I->seeElement('input', ['type'=>'checkbox', 'name'=>'foo']);
$I->see('bar');
