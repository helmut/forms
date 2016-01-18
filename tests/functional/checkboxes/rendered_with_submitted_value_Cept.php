<?php 

$I = new FunctionalTester($scenario);
$I->amOnPage(script(__FILE__));

$I->click('Go');
$I->dontSeeCheckboxIsChecked('input[name=foo_a]');
$I->dontSeeCheckboxIsChecked('input[name=foo_b]');
$I->dontSeeCheckboxIsChecked('input[name=foo_c]');

$I->moveBack();

$I->checkOption('input[name=foo_a]');
$I->checkOption('input[name=foo_c]');
$I->click('Go');
$I->seeCheckboxIsChecked('input[name=foo_a]');
$I->dontSeeCheckboxIsChecked('input[name=foo_b]');
$I->seeCheckboxIsChecked('input[name=foo_c]');
