<?php 

$I = new FunctionalTester($scenario);
$I->amOnPage(script(__FILE__));

$I->seeElement('select', ['name'=>'foo']);
$I->see('bar');
