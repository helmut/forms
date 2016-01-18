<?php 

$I = new FunctionalTester($scenario);
$I->amOnPage(script(__FILE__));

$I->click('Go');
$I->see('Submitted []');
