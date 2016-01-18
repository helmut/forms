<?php 

$I = new FunctionalTester($scenario);
$I->amOnPage(script(__FILE__));

$I->seeCheckboxIsChecked('input[name=foo_a]');
$I->dontSeeCheckboxIsChecked('input[name=foo_b]');
$I->seeCheckboxIsChecked('input[name=foo_c]');
