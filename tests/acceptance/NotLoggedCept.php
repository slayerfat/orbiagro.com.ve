<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('edit a product while im not logged in');
$I->expect('to redirected to login form');
$I->amOnPage('/productos/1/edit');
$I->expect('to see the login form');
$I->see('Entrar', '.panel-heading');
$I->seeElement('form');
$I->seeElement('input', ['name' => 'email']);
$I->seeElement('input', ['name' => 'password']);
$I->seeElement('button', ['type' => 'submit']);
