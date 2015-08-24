<?php namespace Tests\Acceptance;

use Tests\TestCase;

/**
 * https://github.com/slayerfat/orbiagro.com.ve/blob/b4bf4899453945750e9506cbe394d2ecee9531f2/tests/acceptance/404Cept.php
 */
class CunaguaroHTTPNotFound extends TestCase
{

    public function testRandomPage()
    {
        $this->markTestIncomplete('A espera que Laravel implemente see() para que busque segun elemento, EJ: texto, h1');
        $this->visit('/randomPage')
        ->see('#cunaguaro')
        ->see('404');
    }
}
