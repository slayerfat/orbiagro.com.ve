<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('check that the navbar is correct.');
$I->expect('no random errors in home page.');
$I->amOnPage('/');
$I->dontSee('Whoops');
$I->dontSee('404', 'h1');
$I->expect('to see the basic navbar layout');
$I->seeElement('#main-navbar');
$I->seeElement('#main-navbar-collapse-1');
$I->seeElement('#main-navbar-user');
$I->see('orbiagro.com.ve');
