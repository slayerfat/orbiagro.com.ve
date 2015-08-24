<?php namespace Tests\Acceptance;

use Tests\TestCase;

/**
 * https://github.com/slayerfat/orbiagro.com.ve/blob/b4bf4899453945750e9506cbe394d2ecee9531f2/tests/acceptance/EditProductCept.php
 */
class ProductTest extends TestCase
{

    public function testUnauthorizedUserCantEditProduct()
    {
        $this->markTestIncomplete('A espera que Laravel implemente see() para que busque segun elemento, EJ: texto, h1');
        $this->visit('/productos/1/editar')
        ->see('Entrar');
    }

    public function testNonOwnerCantEditProduct()
    {
        $this->markTestIncomplete();
        $user = factory(\Orbiagro\Models\User)->create();
        $this->actingAs($user)
        ->visit('/productos/1/editar')
        ->see('Ud. no tiene permisos para esta accion.')
        ->seePageIs('/about-us');
    }
}
