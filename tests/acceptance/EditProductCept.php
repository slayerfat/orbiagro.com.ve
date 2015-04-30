<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('try to edit a product that im not owner of');
$I->amLoggedAs(App\User::where('name', 'dummy')->first());
$I->expect('to fail the product edit');
$I->amOnPage('/productos/1/edit');
$I->see('Ud. no tiene permisos para esta accion.');
