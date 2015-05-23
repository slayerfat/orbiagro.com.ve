<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('check the products index layout');
$I->amGoingTo('visit the product index');
$I->amOnPage('productos');
$I->expect('see the category gallerie');
$I->see('.carrusel-cats');
$I->expect('see the category title');
$I->see('Categorias', 'h1');
$I->expect('see the sub-category title');
$I->see('Rubros', 'h1');
$I->expect('see product media list');
$I->seeElement('.product-media');
$I->seeElement('.product-title');
$I->seeElement('.product-price');
