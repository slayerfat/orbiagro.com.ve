<?php namespace Tests\Acceptance;

use Tests\TestCase;

class ProductTest extends TestCase {

  public function testUnauthorizedUserCantEditProduct()
  {
    $this->markTestIncomplete('A espera que Laravel implemente see() para que busque segun elemento, EJ: texto, h1');
    $this->visit('/productos/1/editar')
         ->see('Entrar');
  }

  public function testNonOwnerCantEditProduct()
  {
    $this->markTestIncomplete();
    $user = factory('App\User')->create();
    $this->actingAs($user)
          ->visit('/productos/1/editar')
          ->see('Ud. no tiene permisos para esta accion.')
          ->seePageIs('/about-us');
  }
}
