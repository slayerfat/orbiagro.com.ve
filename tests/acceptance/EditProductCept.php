<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('try to edit a product that im not owner of');
$dummy = App\User::where('name', 'dummy')->first();
$I->amLoggedAs($dummy);
$I->expect('to fail the product edit');
$I->amOnPage('/productos/1/edit');
$I->see('Ud. no tiene permisos para esta accion.');
