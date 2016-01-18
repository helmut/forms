<?php 

$I = new FunctionalTester($scenario);
$I->amOnPage(script(__FILE__));

$I->seeElement('button', ['name'=>'foo']);
$I->see('bar');
