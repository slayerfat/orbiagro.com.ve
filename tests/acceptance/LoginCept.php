<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('sign in with valid account');
$I->amOnPage('/auth/login');
$I->seeLink('Registrarse','/auth/register');
$I->seeLink('Entrar','/auth/login');
$I->expect('Fill the form and be able to login');
$I->submitForm('#form-login', [
  'email' => env('APP_USER_EMAIL'),
  'password' => env('APP_USER_PASSWORD')
]);
$I->seeAuthentication();
$I->amOnPage('/');
$I->see('orbiagro.com.ve');
$I->see(env('APP_USER'));
