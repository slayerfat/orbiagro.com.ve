<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('sign in with valid account');
$I->amOnPage('/auth/login');
$I->seeLink('Registrarse','/auth/register');
$I->seeLink('Entrar','/auth/login');
$I->expect('to fill the form and be able to login');
$I->seeElement('form');
$I->seeElement('input', ['name' => 'email']);
$I->seeElement('input', ['name' => 'password']);
$I->seeElement('button', ['type' => 'submit']);
$I->fillField(['name' => 'email'], env('APP_USER_EMAIL'));
$I->fillField(['name' => 'password'], env('APP_USER_PASSWORD'));
$I->click('Entrar', 'button');
$I->seeAuthentication();
// $I->seeCurrentUrlEquals('/');
$I->see('orbiagro.com.ve', '.navbar-brand');
// $I->see(env('APP_USER'));
