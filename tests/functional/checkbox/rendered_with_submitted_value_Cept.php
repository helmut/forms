<?php 

$I = new FunctionalTester($scenario);
$I->amOnPage(script(__FILE__));

$I->click('Go');
$I->dontSeeCheckboxIsChecked('input[name=foo]');

$I->moveBack();

$I->checkOption('input[name=foo]');
$I->click('Go');
$I->seeCheckboxIsChecked('input[name=foo]');
