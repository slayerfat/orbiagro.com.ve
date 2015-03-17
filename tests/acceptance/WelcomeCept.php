<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that welcome scaffold works');
$I->amOnPage('/welcome');
$I->see('orbiagro.com.ve');
