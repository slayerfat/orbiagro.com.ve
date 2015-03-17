<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('see a cunaguaro');
$I->amOnPage('/randomPageLoL');
$I->see('#cunaguaro');
$I->see('404', 'h1');
