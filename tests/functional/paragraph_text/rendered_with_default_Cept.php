<?php 

$I = new FunctionalTester($scenario);
$I->amOnPage(script(__FILE__));

$I->seeInField('textarea[name=foo]', 'baz');
