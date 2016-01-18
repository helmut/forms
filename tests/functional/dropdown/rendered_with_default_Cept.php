<?php 

$I = new FunctionalTester($scenario);
$I->amOnPage(script(__FILE__));

$I->seeOptionIsSelected('select[name=foo]', 'B');
