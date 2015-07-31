<?php namespace Tests\App;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Tests\TestCase;

class AppCategoryTest extends TestCase {

  use DatabaseTransactions;

  /**
   * A basic functional test example.
   *
   * @return void
   */
  public function testBasicExample()
  {
    $this->assertTrue(true);
  }

}
