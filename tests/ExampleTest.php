<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase {

  // use DatabaseTransactions;

  /**
   * A basic functional test example.
   *
   * @return void
   */
  public function testBasicExample()
  {
    $this->visit('/welcome')
          ->see('orbiagro')
          ->dontSee('Laravel 5');
  }

}
