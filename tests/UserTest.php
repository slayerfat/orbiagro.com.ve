<?php

class UserTest extends TestCase {

  public function setUp()
  {
    parent::setUp();
    Artisan::call('migrate');
  }

  /**
   * A basic functional test example.
   *
   * @return void
   */
  public function testBasicExample()
  {
    
  }

}
