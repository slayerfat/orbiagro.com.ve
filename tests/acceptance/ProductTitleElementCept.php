<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('check the title in the view');
$I->expect('see relevant info of the product in the title');
$I->amGoingTo('visit the product page');
$I->amOnPage('productos/1');
$product = App\Product::first();
$I->seeInTitle("orbiagro.com.ve");
$I->seeInTitle("Productos");
$I->seeInTitle("{$product->price_bs()}");
$I->seeInTitle("{$product->title}");
