<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('check if im authorized to do an ajax request');
$I->sendAjaxGetRequest('/estados');
$I->see('Unauthorized.');
