<?php 

$I = new FunctionalTester($scenario);
$I->amOnPage(script(__FILE__));

$I->seeCheckboxIsChecked('input[name=foo]');
