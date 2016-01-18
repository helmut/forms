<?php 

$I = new FunctionalTester($scenario);
$I->amOnPage(script(__FILE__));

$I->seeElement('input', ['type'=>'checkbox', 'name'=>'foo_a']);
$I->seeElement('input', ['type'=>'checkbox', 'name'=>'foo_b']);
$I->seeElement('input', ['type'=>'checkbox', 'name'=>'foo_c']);
$I->see('bar');
