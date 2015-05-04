<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('check the directions on the app');
$I->sendAjaxGetRequest('/estados');
$I->see('"description":"Distrito Capital"');
