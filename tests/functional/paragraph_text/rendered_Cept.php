<?php 

$I = new FunctionalTester($scenario);
$I->amOnPage(script(__FILE__));

$I->seeElement('textarea', ['name'=>'foo']);
$I->see('bar');
