<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('check the parishes with town id:1 on the app');
$I->sendAjaxGetRequest('/parroquias/1');
$I->see('"description":"Altagracia"');
$I->wantTo('check the town of the parish id:1 on the app');
$I->sendAjaxGetRequest('/municipio/1');
$I->see('"description":"Libertador"');
