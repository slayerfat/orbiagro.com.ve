<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('check the towns with state id:1 on the app');
$I->sendAjaxGetRequest('/municipios/1');
$I->see('"description":"Libertador"');
$I->wantTo('check the state of the town id:1 on the app');
$I->sendAjaxGetRequest('/municipio/1');
$I->see('"description":"Libertador"');
